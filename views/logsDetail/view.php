<?php
/* @var $this LogsDetailController */
/* @var $model LogsDetail */

$this->breadcrumbs=array(
	'Logs Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LogsDetail', 'url'=>array('index')),
	array('label'=>'Create LogsDetail', 'url'=>array('create')),
	array('label'=>'Update LogsDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LogsDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LogsDetail', 'url'=>array('admin')),
);
?>

<h1>View LogsDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'log_id',
		'step',
		'message',
		'type',
	),
)); ?>
