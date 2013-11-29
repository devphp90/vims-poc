<?php
$this->breadcrumbs=array(
	'Ubs Supplier Seeds'=>array('index'),
	$model->SupplierID=>array('view','id'=>$model->SupplierID),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsSupplierSeed','url'=>array('index')),
	array('label'=>'Create UbsSupplierSeed','url'=>array('create')),
	array('label'=>'View UbsSupplierSeed','url'=>array('view','id'=>$model->SupplierID)),
	array('label'=>'Manage UbsSupplierSeed','url'=>array('admin')),
);
?>

<h1>Update UbsSupplierSeed <?php echo $model->SupplierID; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>