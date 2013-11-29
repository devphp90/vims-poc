<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UbsProductStatus','url'=>array('index')),
	array('label'=>'Create UbsProductStatus','url'=>array('create')),
	array('label'=>'Update UbsProductStatus','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UbsProductStatus','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UbsProductStatus','url'=>array('admin')),
);
?>

<h1>View UbsProductStatus #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'dtCreated',
		'Action',
		'Completed',
		'SKU',
		'StockStatusID',
	),
)); ?>
