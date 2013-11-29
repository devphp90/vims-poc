<?php
$this->breadcrumbs=array(
	'Ubs Supplier Item Seeds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UbsSupplierItemSeed','url'=>array('index')),
	array('label'=>'Create UbsSupplierItemSeed','url'=>array('create')),
	array('label'=>'Update UbsSupplierItemSeed','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UbsSupplierItemSeed','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UbsSupplierItemSeed','url'=>array('admin')),
);
?>

<h1>View UbsSupplierItemSeed #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'SupplierName',
		'SupplierID',
		'SKU',
		'MPN',
		'upc',
		'SupplierSKU',
		'ItemName',
	),
)); ?>
