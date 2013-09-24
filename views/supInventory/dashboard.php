<?php
$this->breadcrumbs=array(
	'Supplier Inventory'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Advanced Search','url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-inventory4-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Supplier Inventory Items</h1>



<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ubs-inventory4-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText'=>'',
	'columns'=>array(
		'id',
		'ubs_inventory.sku',
		'ubs_inventory.sku_name',
		array(
			'name'=>'sup_id',
			'type'=>'raw',
			'htmlOptions'=>array(
				'style'=>'width:10px',
			),
//			'value'=>'(isset($data->supplier)?$data->supplier->name:\'\').\'<br/>\'.$data->sup_id',
			'value'=>'CHtml::link($data->supplier->name,array(\'/Supplier/view\',\'id\'=>$data->sup_id),array(\'target\'=>\'_blank\')).\'<br/>\'.$data->sup_id',
		),
		'sup_price',
		array(
			'header'=>'sQOH<br/>Warehouse detail',
			'headerHtmlOptions'=>array(
				'style'=>'background-color: green;',
			),
			'type'=>'raw',
			'value'=>'$data->qty_total.\' \'.CHtml::ajaxLink("detail",array("/supWarehouseItem/ajaxItem"),array("update" => "#data","data"=>array("id"=>"js:$(this).parents(\'tr\').children(\':first\').html()")))',
		),

		'last_update',
		
		array(
			'header'=>'Read<br/>Edit<br/>Delete',
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<div id="data">
</div>
