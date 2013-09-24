<?php
/* @var $this ImportSheetTypeController */
/* @var $model ImportSheetType */

$this->breadcrumbs=array(
	'Import Sheet Types'=>array('index'),
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

<h1>View ImportSheetType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
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
