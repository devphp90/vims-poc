<?php
/* @var $this UpdateQaGlobalController */
/* @var $model UpdateQaGlobal */

$this->breadcrumbs=array(
	'Update QA Globals'=>array('index'),
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

<h1>View UpdateQAGlobal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_percent',
		'instock_percent',
		'qoh_percent',
		'price_percent',
		'create_by',
		'update_by',
		'create_time',
		'update_time',
	),
)); ?>
