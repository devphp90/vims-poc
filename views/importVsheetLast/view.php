<?php
$this->breadcrumbs=array(
	'Import Vsheet Lasts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ImportVsheetLast','url'=>array('index')),
	array('label'=>'Create ImportVsheetLast','url'=>array('create')),
	array('label'=>'Update ImportVsheetLast','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ImportVsheetLast','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ImportVsheetLast','url'=>array('admin')),
);
?>

<h1>View ImportVsheetLast #<?php echo $model->id; ?></h1>

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
		'mfg_sku',
		'mfg_name',
		'mfg_part_name',
		'upc',
		'sup_sku_name',
	),
)); ?>
