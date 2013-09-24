
<style type="text/css">
	.table td,
	.table th
	{
		padding: 0px 2px 2px 0px;
		
		text-align: center;
	}
	.matched
	{
		
		background-color: #dff0d8
	}
</style>
<script>

function checkAllForPage()
{
	if(!confirm('Are you sure?  Check All Yes if Match for this Page?')) return false;
	$('input:radio').each(function(){
	
		var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');
		
		if(match != '' && $(this).attr("value") == 1){
			
			$(this).attr("checked", true);
			
			$.ajax({

		    	type: "GET",
		
		    	url: "<?php echo $this->createUrl('/supNewItem/updateMatch')?>",
		
		    	data: {
		
		    		id: $(this).attr(":id"),
		    		value: $(this).attr("value")
		
		    	},
		
		    	success: function(result) {
			    	//console.log('ggyy');
		    	},
		
		    });
			 
		}
		
	});
}


function accept_page()
{
	if(confirm('Are you sure you want to import this page?')) {
		var checkers = '';
		$(".checkernum").each(function(){
			checkers += $(this).attr(':checkid') + ',';
			
		});
		var checkerArr = checkers.split(',');
		delete checkerArr[checkerArr.length-1];

//		jQuery.yii.submitForm(this,'/index.php/supNewItem/import?checkers=' + checkers,{});
		location.href = '/index.php/supNewItem/importpage?checkers=' + checkers;
		console.log(checkerArr);
	} 
	else 
		return false;
}


$(function(){

	$('input:radio').click(function(){
		var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');
		//console.log(match);
		if(match != '' && $(this).attr("value") == 0)
			if(!confirm('Are you sure?  This item matches.')) return false;
		if(match == '' && $(this).attr("value") == 1)
			if(!confirm('Are you sure?  This item does NOT match.')) return false;
		//if($(this).attr("value") == 0)
		//	
		$.ajax({

	    	type: "GET",
	
	    	url: "<?php echo $this->createUrl('/supNewItem/updateMatch')?>",
	
	    	data: {
	
	    		id: $(this).attr(":id"),
	    		value: $(this).attr("value")
	
	    	},
	
	    	success: function(result) {
		    	//console.log('ggyy');
	    	},
	
	    	error: function(jqXHR, textStatus, errorThrown) {
	
	     	},
	
	    });
	});
});

</script>

<?php
$this->breadcrumbs=array(

	'Sup New Items'=>array('index'),

	'Manage',

);



$this->menu=array(

	array('label'=>'List', 'url'=>array('index')),

	array('label'=>'Delete All', 'url'=>'#', 'linkOptions'=>array('submit'=>array('deleteAll'),'confirm'=>'Are you sure you want to delete all item?')),
	array('label'=>'Accept All', 'url'=>'#', 'linkOptions'=>array('submit'=>array('import'),'confirm'=>'Are you sure you want to import all item?')),
	array('label'=>'Accept Page', 'url'=>'#', 'linkOptions'=>array('onclick'=>'accept_page();')),
	
	array('label'=>'Check All Yes if Match for this Page', 'url'=>'#', 'linkOptions'=>array('onclick'=>'checkAllForPage();')),
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),


);



Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('sup-new-item-grid', {

		data: $(this).serialize()

	});

	return false;

});

");



$this->helpText = 'Proposed match is vSKU from another Supplier, then MPN. If the match is correct, check "Yes", 
otherwise No or Undecided.';

?>



<h1>Supplier New Items and Link to UBS Item ("Checkers")</h1>






<div class="search-form" style="display:none">

<?php $this->renderPartial('_search',array(

	'model'=>$model,

)); ?>

</div><!-- search-form -->



<?php $this->widget('bootstrap.widgets.TbGridView', array(

	'id'=>'sup-new-item-grid',
	'type'=>'bordered',
	'dataProvider'=>$model->searchChecker(),
	'ajaxUpdate'=>false,
	'rowCssClassExpression'=>'$data->match_by?"matched ":""',
	'columns'=>array(

		'testvalue',
		'testvalue1',
		'testvalue2',
		array(
			'header'=>'Match<br/>By',
			'name'=>'match_by',
			'htmlOptions'=>array(
				'style'=>'width:23px;',
			),
		),
		array(

			'header'=>'Match<br/>Yes/No/Un',
			'name'=>'match',
			'type'=>'raw',
			'value'=>'CHtml::radioButtonList("match_".$data->id,$data->match, array(1=>"Y",0=>"N",2=>"U"),array(":id"=>$data->id,"labelOptions"=>array("style"=>"display:inline;",),"separator"=>" ","template"=>"{label}{input}"))',
			'htmlOptions'=>array(
				'style'=>'width:100px;',
			),

		),
		array(

			'header'=>'% Diff',
			'name'=>'percent_diff',
			'value'=>'$data->ubsinventory->price == 0?"n/a":sprintf("%.2f",(abs($data->ubsinventory->price-$data->sup_price)/$data->ubsinventory->price)*100)."%"',
			'htmlOptions'=>array(
				'style'=>'width:55px;',
			),
		),


		array(

			'header'=>'UBS<br/>Item<br/>Cost',

			'value'=>'$data->ubsinventory->price',
			'htmlOptions'=>array(
				'style'=>'width:35px;',
			),
		),
		
		array(

			'header'=>'Supp<br/>Item<br/>Price',

			'value'=>'(!empty($data->ubsinventory)?$data->sup_price:\'\')',
			'htmlOptions'=>array(
				'style'=>'width:30px;',
			),
		),

		array(

			'header'=>'Price<br/>Diff',

			'name'=>'price_diff',
			'htmlOptions'=>array(
				'style'=>'width:30px;',
			),
			
			'value'=>'(!empty($data->ubsinventory)?($data->ubsinventory->price-$data->sup_price):\'\')',
		),
		array(

			'header'=>'UBS<br/>SKU',

			'value'=>'$data->ubsinventory->sku'

		),
		
		array(

			'header'=>'Supplier',

			'name'=>'sup_id',

			'type'=>'raw',


			'value'=>'isset($data->supplier)?$data->supplier->name.\'(\'.$data->import_routine->sup_id.\')\':"<font color=\"red\">Routine Deleted</font>"',

		),

		array(

			'header'=>'UBS<br/>Item<br/>Name',
			'type'=>'raw',

			'value'=>'(strlen($data->ubsinventory->sku_name)>10)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->ubsinventory->sku_name."\">".substr($data->ubsinventory->sku_name,0,10)."...</a>":$data->ubsinventory->sku_name',

		),
		array(
			'header'=>'Mfg<br/>Part<br/>Name',
			'name'=>'mfg_part_name',
			'type'=>'raw',
			'value'=>'(strlen($data->mfg_part_name)>10)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->mfg_part_name."\">".substr($data->mfg_part_name,0,10)."...</a>":$data->mfg_part_name',
		),
		array(
			'header'=>'Supp<br/>Mfg<br/>Name',
			'name'=>'mfg_name',
			'type'=>'raw',
			'value'=>'(strlen($data->mfg_name)>10)?"<a href=\"#\" title=\"".$data->mfg_name."\" rel=\"tooltip\">".substr($data->mfg_name,0,10)."...</a>":$data->mfg_name',
		),

		array(
			'header'=>'UBS<br/>Mfg<br/>Name',
			'name'=>'ubsinventory.mfg_title',
			
		),

		array(
			'header'=>'Supp<br/>MPN',
			'name'=>'mfg_sku',
		),
		array(

			'header'=>'UBS<br/>MPN',

			'value'=>'$data->ubsinventory->mfg_name'

		),
		
		array(
			'header'=>'Supp<br/>UPC',
			'name'=>'upc',
		),
		array(
			'header'=>'UBS<br/>UPC',
			'name'=>'ubsinventory.upc',
		),
		array(
			'header'=>'Will<br/>Auto<br/>Accept?',
			'type'=>'raw',
			'value'=>'$data->importStatus != \'Will Import\'?CHtml::link("no","#",array("rel"=>"tooltip","title"=>$data->importStatus)):yes',
			'htmlOptions'=>array(
				'style'=>'width:20px;',
			),
		),
		array(
			'header'=>'Info',
			'type'=>'raw',
			'value'=>'"<a href=\"#\" class=\"checkernum\" :checkid=\"".$data->id."\" title=\"ubs_id = ".$data->ubsinventory->id.",vims_id = ".$data->id.",vsku =".$data->sup_vsku.",import_id=".$data->import_routine->id."\" rel=\"tooltip\">info</a>"',
			'htmlOptions'=>array(
				'style'=>'width:20px;',
				
			),
		),

		array(

			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'htmlOptions'=>array(
				'style'=>'width:10px;',
			),

		),

	),

)); ?>


