<?php
$this->breadcrumbs=array(
	'Ubs Supplier Seeds'=>array('index'),
	$model->SupplierID,
);

$this->menu=array(
	array('label'=>'List UbsSupplierSeed','url'=>array('index')),
	array('label'=>'Create UbsSupplierSeed','url'=>array('create')),
	array('label'=>'Update UbsSupplierSeed','url'=>array('update','id'=>$model->SupplierID)),
	array('label'=>'Delete UbsSupplierSeed','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->SupplierID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UbsSupplierSeed','url'=>array('admin')),
);
?>

<h1>View UbsSupplierSeed #<?php echo $model->SupplierID; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'SupplierID',
		'SupplierName',
	),
)); ?>
