<?php
$this->breadcrumbs=array(
	'Ubs Supplier Stats'=>array('index'),
	$model->SupplierId=>array('view','id'=>$model->SupplierId),
	'Update',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'View ','url'=>array('view','id'=>$model->SupplierId)),
);
?>

<h1>Update UbsSupplierStat <?php echo $model->SupplierId; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>