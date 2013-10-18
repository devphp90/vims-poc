<?php
$this->breadcrumbs=array(
	'Ubs Control Tables'=>array('index'),
	$model->TableId,
);

$this->menu=array(
	array('label'=>'List UbsControlTable','url'=>array('index')),
	array('label'=>'Create UbsControlTable','url'=>array('create')),
	array('label'=>'Update UbsControlTable','url'=>array('update','id'=>$model->TableId)),
	array('label'=>'Delete UbsControlTable','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->TableId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UbsControlTable','url'=>array('admin')),
);
?>

<h1>View UbsControlTable #<?php echo $model->TableId; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'TableId',
		'TableName',
		'Status',
		'DateLastUpdate',
	),
)); ?>
