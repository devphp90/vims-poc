
<style type="text/css">
	.table td,
	.table th
	{
		padding: 0px 2px 2px 0px;

		text-align: left;
	}
	.matched
	{

		background-color: #dff0d8
	}
  .mismatched {background-color: #FCF2F2;}
</style>

<script>
$(function(){
	var i = 0;
	//jQuery.event.trigger({ type : 'keypress', which : 9 });

	$(document).keydown(function(e){
		if(e.keyCode == 38){

			if($('[tabIndex=' + (i-1) +']').attr('name') != undefined){

				$('[tabIndex=' + --i +']').focus();
			}
		}
		if(e.keyCode == 40){
			if($('[tabIndex=' + (i+1) +']').attr('name') != undefined){

				$('[tabIndex=' + ++i +']').focus();
			}
		}
	});

});
function checkAllForPage()
{
	var checkers = '';
	if(!confirm('Are you sure?  Check All Yes if Match for this Page?')) return false;
	$('input:radio').each(function(){
		
		var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');

		if(match != '' && $(this).attr("value") == 1){
			checkers += $(this).parent().find('input').attr(':id') + ',';
			$(this).attr("checked", true);
		}

	});
	$.ajax({
		type: "GET",

    	url: "<?php echo $this->createUrl('/supNewItem/updatePageY')?>",

    	data: {

    		checkers: checkers,

    	},

    	success: function(result) {
    		alert('Check All Yes done.');
    	},

	});
}

function checkAllNoForPage()
{
	var checkers = '';
	if(!confirm('Are you sure?  Check All No if Match for this Page?')) return false;
	$('input:radio').each(function(){

		var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');

		if(match == '' && $(this).attr("value") == 0){
			checkers += $(this).parent().find('input').attr(':id') + ',';
			$(this).attr("checked", true);
		}

	});
	$.ajax({
		type: "GET",

    	url: "<?php echo $this->createUrl('/supNewItem/updatePageN')?>",

    	data: {

    		checkers: checkers,

    	},

    	success: function(result) {
    		alert('Check All No done.');
    	},

	});
}



function accept_page()
{

	if(confirm('Are you sure you want to import this page?')) {
		var checkers = '';
		$(".checkernum").each(function(){
			checkers += $(this).attr(':checkid') + ',';
			console.log($(this).attr(':checkid'));
		});
		var checkerArr = checkers.split(',');
		delete checkerArr[checkerArr.length-1];

//		jQuery.yii.submitForm(this,'/index.php/supNewItem/import?checkers=' + checkers,{});
		url = '/index.php/supNewItem/importpage?checkers=' + checkers;
		window.open( url , "_blank" );
		return false;
	}
	else
		return false;
}


$(function(){

	$('input:radio').click(function(){
    var value = $(this).attr("value");

		var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');
		if(match != '' && $(this).attr("value") == 0)
			if(!confirm('Are you sure?  This item matches.')) return false;
		if(match == '' && $(this).attr("value") == 1)
			if(!confirm('Are you sure?  This item does NOT match.')) return false;
		//if($(this).attr("value") == 0)
		//
    // check for the rest
//    console.log($('.'+$(this).attr('class')));
		$.ajax({

	    	type: "GET",

	    	url: "<?php echo $this->createUrl('/supNewItem/updateMatch')?>",

	    	data: {

	    		id: $(this).attr(":id"),
	    		value: $(this).attr("value")

	    	},

	    	success: function(result) {
          if (value == 1) {
            location.reload();
          }
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

	array('label'=>'Delete All', 'url'=>'#', 'linkOptions'=>array('submit'=>array('deleteAll?id='.$supid),'confirm'=>'Are you sure you want to delete all item?')),
  array('label'=>'Delete All MisMatch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('deleteAllMarkedAsMisMatch?id='.$supid),'confirm'=>'Are you sure you want to delete all items marked as mismatch?')),
	//array('label'=>'Accept All', 'url'=>'#', 'linkOptions'=>array('submit'=>array('import'),'confirm'=>'Are you sure you want to import all item?','target'=>'_blank')),
    array('label'=>'Accept All', 'url'=>'#', 'linkOptions'=>array('title'=>'Under Construction')),
	array('label'=>'Accept Page', 'url'=>'#', 'linkOptions'=>array('onclick'=>'accept_page();','target'=>'_blank')),
	array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#accept',
		),
	),

	array('label'=>'Check All Yes if Match for this Page', 'url'=>'#', 'linkOptions'=>array('onclick'=>'checkAllForPage();')),
	array('label'=>'Check All No if Not Match for this Page', 'url'=>'#', 'linkOptions'=>array('onclick'=>'checkAllNoForPage();')),
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





?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'accept')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>


	<div class="modal-body">
    <p>VIMS proposes a match based on:</p>
    <ol>
      <li>vSKU from another Supplier; then</li>
      <li>MPN+UPC from UBS Items, then</li>
      <li>MPN+Mfg Name from UBS Items, then</li>
      <li>UPC, then</li>
      <li>MPN</li>
    </ol>
    <p>If the match is correct, check "Yes", otherwise No or Undecided.</p>
	</div>

	<div class="modal-footer">


		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>

<?php if ($supplier): ?>
  <h1>Manage Supplier New Items ("Checkers"): <?= $supplier->name; ?></h1>
<?php else: ?>
  <h1>Manage Supplier New Items ("Checkers") for ALL Suppliers</h1>
<?php endif; ?>






<div class="search-form" style="display:none">

<?php $this->renderPartial('_search',array(

	'model'=>$model,

)); ?>

</div><!-- search-form -->


<div class="row" align="right">
  <?php $this->widget('application.extensions.PageSize.PageSize', array(
    'mGridId' => 'sup-new-item-grid',
    'mPageSize' => @$_GET['pageSize'],
    'mDefPageSize' => 100,
  ));

  ?>
</div>
<?php
$columns = array(


  array(
    'header'=>'Match<br/>By',
    'name'=>'match_by',
    'htmlOptions'=>array(
      'style'=>'width:23px;',
    ),
    'value'=>'$data->match_by_status[$data->match_by]',
    'filter'=>array(
      SupItemsNewManage::MATCH_VSKU=>'vSKU',
      SupItemsNewManage::MATCH_MPN_UPC_NAME=>'MPN+UPC+Nam',
      SupItemsNewManage::MATCH_MPN_UPC=>'MPN+UPC',
      SupItemsNewManage::MATCH_MPN_NAME=>'MPN+Nam',
      SupItemsNewManage::MATCH_UPC=>'UPC',
      SupItemsNewManage::MATCH_MPN=>'MPN'
    ),
  ),
  array(

    'header'=>'Match<br/>Yes/No/Un',
    'name'=>'match',
    'type'=>'raw',
    'value'=>'CHtml::radioButtonList("match_".$data->id,$data->match, array(1=>"Y",0=>"N",2=>"U"),array(":id"=>$data->id,"class"=>"vsku-$data->sup_vsku","tabindex"=>Yii::app()->controller->tempCounter++,"labelOptions"=>array("style"=>"display:inline;"),"separator"=>" ","template"=>"{label}{input}"))',
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
    'name'=>'sup_price',
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
    'name'=>'ubs_sku',
    'value'=>'$data->ubsinventory->sku'

  ),

  array(

    'header'=>'UBS<br/>Item<br/>Name',
    'type'=>'raw',

    //'value'=>'(strlen($data->ubsinventory->sku_name)>30)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->ubsinventory->sku_name."\">".substr($data->ubsinventory->sku_name,0,30)."...</a>":$data->ubsinventory->sku_name',
    'value'=>'$data->ubsinventory->sku_name',

  ),
  array(
    'header'=>'Mfg<br/>Part<br/>Name',
    'name'=>'mfg_part_name',
    'type'=>'raw',
    //'value'=>'(strlen($data->mfg_part_name)>10)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->mfg_part_name."\">".substr($data->mfg_part_name,0,10)."...</a>":$data->mfg_part_name',
    'value'=>'$data->mfg_part_name',
  ),
  array(
    'header'=>'Supp<br/>Mfg<br/>Name',
    'name'=>'mfg_name',
    'type'=>'raw',
    'htmlOptions'=>array(
      'style'=>'width:120px;',
    ),
    //'value'=>'(strlen($data->mfg_name)>20)?"<a href=\"#\" title=\"".$data->mfg_name."\" rel=\"tooltip\">".substr($data->mfg_name,0,20)."...</a>":$data->mfg_name',
    'value'=>'$data->mfg_name',
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
    'name'=>'ubsinventory.mfg_name',
    'value'=>'$data->ubsinventory->mfg_name'

  ),

  array(
    'header'=>'Supp<br/>UPC',
    'name'=>'upc',
    'value'=>'$data->upc',
  ),
  array(
    'header'=>'UBS<br/>UPC',
    'name'=>'ubsinventory.upc',
    'value'=>'isset($data->ubsinventory->upc)?$data->ubsinventory->upc:""',
  ),
  array(
    'header'=>'Will<br/>Auto<br/>Accept?',
    'type'=>'raw',
    'value'=>'$data->importStatus != \'Will Import\'?CHtml::link("no","#",array("rel"=>"tooltip","title"=>$data->importStatus)):yes',
    'htmlOptions'=>array(
      'style'=>'width:20px;',
    ),
  ),
);

if (!$supplier) {
  $columns[] = array(

    'header'=>'Supplier',

    'name'=>'sup_id',

    'type'=>'raw',


    'value'=>'isset($data->supplier)?$data->supplier->name.\'(\'.$data->import_routine->sup_id.\')\':"<font color=\"red\">Routine Deleted</font>"',

  );
}

$columns[] =  array(
  'header'=>'Info',
  'type'=>'raw',
  'value'=>'"<a href=\"#\" class=\"checkernum\" :checkid=\"".$data->id."\" title=\"ubs_id = ".$data->ubsinventory->id.",vims_id = ".$data->id.",vsku =".$data->sup_vsku.",import_id=".$data->import_routine->id."\" rel=\"tooltip\">info</a>"',
  'htmlOptions' => array('style' => 'width: 50px'),
  'headerHtmlOptions' => array('style' => 'width: 50px'),
);
$columns[] = array(

  'class'=>'CButtonColumn',
  'template'=>'{delete}',
  'htmlOptions'=>array(
    'style'=>'width:10px;',
  ),

);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(

	'id'=>'sup-new-item-grid',
	'type'=>'bordered',
	'dataProvider'=>$model->searchSupchecker(),
	'ajaxUpdate'=>false,
	'ajaxUrl'=>$this->createUrl('/supNewItem/supChecker',array('supid'=>$supid)),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'rowCssClassExpression'=>'$data->match_by?($data->match?"matched":"mismatched"):""',
	'columns'=> $columns,

)); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>


	<div class="modal-body">
		<p>VIMS proposes a match based on:</p>
    <ol>
      <li>vSKU from another Supplier; then</li>
      <li>MPN+UPC from UBS Items, then</li>
      <li>MPN+Mfg Name from UBS Items, then</li>
      <li>UPC, then</li>
      <li>MPN</li>
    </ol>
    <p>If the match is correct, check "Yes", otherwise No or Undecided.</p>
	</div>

	<div class="modal-footer">


		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>

<script src="<?php echo Yii::app()->request->baseUrl?>/js/colResizable-1.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(function(){
    $("table").colResizable({headerOnly: true});
    $("table.items").removeClass("CRZ");
  });
</script>
