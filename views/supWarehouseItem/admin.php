<?php
$this->breadcrumbs=array(
	'Sup Warehouse Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SupWarehouseItem', 'url'=>array('index')),
	array('label'=>'Create SupWarehouseItem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sup-warehouse-item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sup Warehouse Items</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sup-warehouse-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'sup_id',
		'supplier.sup_name',
		'ware_id',
		'warehouse.name',
		'sup_sku',
		'qty_on_hand',
		'price',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
