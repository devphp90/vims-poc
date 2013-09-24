<script>
$(function(){
	
	$('input:radio').click(function(){
		
		$.ajax({

	    	type: "GET",
	
	    	url: "<?php echo $this->createUrl('/supNewItem/updateMatch')?>",
	
	    	data: {
	
	    		id: $(this).attr(":id"),
	    		value: $(this).attr("value")
	
	    	},
	
	    	success: function(result) {

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



$this->helpText = 'Click Update List to populate Supplier New Item grid with possible match to UBS Item.<br/>The match is based on MPN. If a match is found, check the "Same" box.';

?>



<h1>Manage Supplier New Items and Link UBS Item</h1>






<div class="search-form" style="display:none">

<?php $this->renderPartial('_search',array(

	'model'=>$model,

)); ?>

</div><!-- search-form -->



<?php $this->widget('bootstrap.widgets.TbGridView', array(

	'id'=>'sup-new-item-grid',

	'dataProvider'=>$model->searchImportedMatch(),
	'ajaxUpdate'=>false,
	'filter'=>$model,

	'columns'=>array(

		'id',

		'import_id',


		array(

			'header'=>'Supplier',

			'name'=>'sup_id',

			'type'=>'raw',

			'headerHtmlOptions'=>array(

				'style'=>'background-color: #666666;',

			),

			'value'=>'$data->supplier->name.\'<br/>\'.$data->import_routine->sup_id',

		),


		array(

			'name'=>'sup_vsku',

			'headerHtmlOptions'=>array(

				'style'=>'background-color: #666666;',

			),

		),

		array(

			'name'=>'sup_sku',

			'headerHtmlOptions'=>array(

				'style'=>'background-color: #666666;',

			),

		),

		array(

			'name'=>'sup_sku_name',

			'headerHtmlOptions'=>array(

				'style'=>'background-color: #666666;',

			),

		),

		array(

			'name'=>'sup_description',	

			'headerHtmlOptions'=>array(

				'style'=>'background-color: #666666;',

			),

		),

		





		

		'mfg_sku',

		'upc',

		'mfg_name',

		'mfg_part_name',


		array(
			'type'=>'raw',
			'value'=>'CHtml::ajaxLink("Re-import",array("/supNewItem/updateStatus","id"=>$data->id,"value"=>0),array("success"=>"function(){ $.fn.yiiGridView.update(\'sup-new-item-grid\');}"))',
		),

		

		

		array(

			'class'=>'CButtonColumn',

		),

	),

)); ?>


