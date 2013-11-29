<?php
$this->breadcrumbs=array(
	'Ubs Supplier Seeds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UbsSupplierSeed','url'=>array('index')),
	array('label'=>'Manage UbsSupplierSeed','url'=>array('admin')),
);
?>

<h1>Create UbsSupplierSeed</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>