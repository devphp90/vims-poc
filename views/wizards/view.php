<?php
/* @var $this WizardsController */
/* @var $model Wizards */

$this->breadcrumbs=array(
	'Sup Setup'=>array('index'),
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

<h1>View Supplier Setups #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sup_name',
		//'data_md5',
		//'data',
		'create_time',
		'create_by',
		'update_by',
		'update_time',
		array(
			'name'=>'status',
			'value'=>$model->status?'Complete':'In Progress',
		),
	),
)); ?>
