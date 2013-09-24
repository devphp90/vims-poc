<?php
$this->breadcrumbs=array(
	'Sup Warehouse Items'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List SupWarehouseItem', 'url'=>array('index')),
//	array('label'=>'Create SupWarehouseItem', 'url'=>array('create')),
	array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete SupWarehouseItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage SupWarehouseItem', 'url'=>array('admin')),
);
?>

<h1>View SupWarehouseItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ware_id',
		'qty_on_hand',
		'price',
		'create_time',
		'update_time',
		array(
			'label'=>'Create by',
			'name'=>'create_user.username',
		),
		array(
			'label'=>'Update by',
			'name'=>'update_user.username',
		),
	),
)); ?>
