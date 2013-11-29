<?php
$this->breadcrumbs=array(
	'Ubs Supplier Item Seeds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsSupplierItemSeed','url'=>array('index')),
	array('label'=>'Create UbsSupplierItemSeed','url'=>array('create')),
	array('label'=>'View UbsSupplierItemSeed','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UbsSupplierItemSeed','url'=>array('admin')),
);
?>

<h1>Update UbsSupplierItemSeed <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>