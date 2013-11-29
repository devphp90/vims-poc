<?php
$this->breadcrumbs=array(
	'Tabs Update Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
		'label'=>'Search', 
		'url'=>'#',
		'linkOptions'=>array(
			'class'=>'search-button',
		),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tabs-update-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Supplier Failed Update List</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tabs-update-log-grid',
	'dataProvider'=>$model->failsearch(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'tab.supplier.name',
		),
		array(
			'name'=>'tab.supplier.active',
			'type'=>'raw',
			'value'=>'CHtml::ajaxLink($data->tab->supplier->active?"Active":"Inactive",Yii::app()->controller->createUrl("/supplier/statusToggle",array("id"=>$data->tab->supplier_id)),array(
				"success"=>\'function(res){$(".status_\'.$data->tab->supplier_id.\'").html(res)}\',
			
			),array(
				"class"=>"status_".$data->tab->supplier_id,
			
			));',
		),
		array(

			'header'=>'Sheet Changes <br/>Qty and/or Price<br/>PASS/FAIL <a href="#" rel="tooltip" title="A sheet could FAIL if a % of Items change QTY and/or Price. If Rule=50%, and 51% of Items had a Price change from last Update, then FAIL. If 25% had a QTY change AND 26% had a Price change, then FAIL." style="display:inline;">(?)</a>',

			'name'=>'data_integrity_status',

			'type'=>'raw',

			'value'=>'$data->_status[$data->data_integrity_status]."<br/>".$data->data_integrity_reason',

			'sortable'=>false,

		),

		array(

			'header'=>'Sheet Changes <br/>Items InStock<br/>PASS/Fail <a href="#" rel="tooltip" title="FAIL if % of Items change stock status.  If Rule=20%, and 30% go from InStock to BO, then FAIL. Buffer rules apply to determine stock status." style="display:inline;">(?)</a>',

			'name'=>'instock_item_status',

			'type'=>'raw',

			'value'=>'$data->_status[$data->instock_item_status]."<br/>".$data->instock_item_reason',

			'sortable'=>false,

		),


		array(
			'header'=>'Reason<br/>for FAIL',
			'value'=>'',
		),
		array(
			'header'=>'Action<br/>Taken',
			'type'=>'raw',
			'value'=>'CHtml::dropDownList(\'test\',\'\',array("re-mapped sheet","changed QA rule","other"))',
		),
		array(
			'header'=>'Create Date/Time',
			'name'=>'create_time',
		),
		array(
			'header'=>'Finish Date/Time',
			'name'=>'finish_time',
		),
		array(

			'header'=>'Instock Item',

			'name'=>'item',

			'sortable'=>false,

		),

		



		array(

			'name'=>'status',

			'sortable'=>false,

		),
		
		array(

			'header'=>'Supplier ID',

			'name'=>'tab.supplier_id',

		),
		array(

			'name'=>'id',

			'sortable'=>false,

		),

		
		/*
		'price_item_percent_change_status',
		'price_item_percent_change_reason',
		'instock_item_status',
		'instock_item_reason',
		'qoh_percent_change_status',
		'qoh_percent_change_reason',
		'price_percent_change_status',
		'price_percent_change_reason',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
