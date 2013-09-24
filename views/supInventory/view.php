<?php
$this->breadcrumbs=array(
	'Supplier Inventory'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>View Supplier Inventory Items #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ubs_id',
		'sup_id',
		'sup_sku',
		'sup_sku_name',
		'sup_description',
		'sup_price',
		'sup_vsku',
		'sup_vqoh',
		'sup_status',
		'mfg_sku',
		'mfg_sku_plain',
		'mfg_name',
		'mfg_sku_name',
		'mfg_upc',
		'last_update',
		'last_bo_update',
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
