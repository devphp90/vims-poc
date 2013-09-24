<?php
/* @var $this UbsPercentageRuleController */
/* @var $model UbsPercentageRule */

$this->breadcrumbs=array(
	'Difference In Cost Percentage Rule'=>array('index'),
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

<h1>View Difference In Cost Percentage Rule #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'start_price',
		'end_price',
		array(
			'name'=>'percent',
			'value'=>$model->percent.'%',
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
