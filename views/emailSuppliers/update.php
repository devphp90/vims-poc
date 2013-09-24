<?php
$this->breadcrumbs=array(
	'Email Suppliers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmailSuppliers','url'=>array('index')),
	array('label'=>'Create EmailSuppliers','url'=>array('create')),
	array('label'=>'View EmailSuppliers','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage EmailSuppliers','url'=>array('admin')),
);
?>

<h1>Update EmailSuppliers <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>