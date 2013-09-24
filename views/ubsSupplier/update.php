<?php
$this->breadcrumbs=array(
	'Ubs Suppliers'=>array('index'),
	$model->SupplierID=>array('view','id'=>$model->SupplierID),
	'Update',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'View ','url'=>array('view','id'=>$model->SupplierID)),
);
?>

<h1>Update UbsSupplier <?php echo $model->SupplierID; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>