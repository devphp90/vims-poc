<?php
/* @var $this SystemInfoController */
/* @var $model SystemInfo */

$this->breadcrumbs=array(
	'System Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>View SystemInfo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cancel_rate_limit',
		'percent_change',
		'primary_email',
		'secondary_email',
	),
)); ?>
