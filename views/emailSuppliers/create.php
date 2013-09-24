<?php
$this->breadcrumbs=array(
	'Email Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmailSuppliers','url'=>array('index')),
	array('label'=>'Manage EmailSuppliers','url'=>array('admin')),
);
?>

<h1>Create EmailSuppliers</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>