<?php
$this->breadcrumbs=array(
	'Import Vsheets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ImportVsheet','url'=>array('index')),
	array('label'=>'Create ImportVsheet','url'=>array('create')),
	array('label'=>'Update ImportVsheet','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ImportVsheet','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ImportVsheet','url'=>array('admin')),
);
?>

<h1>View ImportVsheet #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'import_id',
		'sup_vsku',
		'price',
		'map',
		'ware_1',
		'ware_2',
		'ware_3',
		'ware_4',
		'ware_5',
		'ware_6',
		'mfg_sku',
		'mfg_name',
		'upc',
		'sup_sku_name',
	),
)); ?>
