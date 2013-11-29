<?php
$this->breadcrumbs=array(
	'Ubs Sku Feeds'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List UbsSkuFeed','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'Update ','url'=>array('update','id'=>$model->SKU)),
	array('label'=>'Delete ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->SKU),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ','url'=>array('admin')),
);
?>

<h1>View UbsSkuFeed #<?php echo $model->SKU; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'dtCreated',
		'Action',
		'Completed',
		'SKU',
		'name',
		'salePrice',
		'manufacturer',
		'MPN',
		'upc',
		'ourCost',
	),
)); ?>
