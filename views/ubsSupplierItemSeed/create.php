<?php
$this->breadcrumbs=array(
	'Ubs Supplier Item Seeds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UbsSupplierItemSeed','url'=>array('index')),
	array('label'=>'Manage UbsSupplierItemSeed','url'=>array('admin')),
);
?>

<h1>Create UbsSupplierItemSeed</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>