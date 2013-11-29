<?php
$this->breadcrumbs=array(
	'Sup Warehouse Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List SupWarehouseItem', 'url'=>array('index')),
//	array('label'=>'Create SupWarehouseItem', 'url'=>array('create')),
//	array('label'=>'View SupWarehouseItem', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage SupWarehouseItem', 'url'=>array('admin')),
);
?>

<h1>Update SupWarehouseItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>