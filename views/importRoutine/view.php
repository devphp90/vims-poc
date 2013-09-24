<?php
$this->breadcrumbs=array(
	'Import Routine4s'=>array('index'),
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

<h1>View Supplier Import Routines #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sup_id',
		'supplier.name',
		'method_id',
		'import_method.type',
		'file_id',
		'file_type.type',
		'file_name',
		'import_server.name',
		'match_column',
		'sup_match_column',

		'frequency',
		'frequency_option',
		'status',
		'import.import_file_url',
		'import.last_import_time',
		array(
			'name'=>'bandwidth',
			'value'=>$model->import->bandwidth.' Bytes',
		),
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
