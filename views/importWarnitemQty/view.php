<?php
$this->breadcrumbs=array(
	'Import Warnitem Qties'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ImportWarnitemQty','url'=>array('index')),
	array('label'=>'Create ImportWarnitemQty','url'=>array('create')),
	array('label'=>'Update ImportWarnitemQty','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ImportWarnitemQty','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ImportWarnitemQty','url'=>array('admin')),
);
?>

<h1>View ImportWarnitemQty #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'import_id',
		'sheet_type',
		'update_type',
		'sup_vsku',
		'price',
		'map',
		'ware_1',
		'ware_2',
		'ware_3',
		'ware_4',
		'ware_5',
		'ware_6',
		'qty',
		'lastqty',
		'mfg_sku',
		'mfg_name',
		'mfg_part_name',
		'upc',
		'sup_sku_name',
	),
)); ?>
