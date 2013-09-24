<?php
$this->breadcrumbs=array(
	'Sup Warehouse Items'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List SupWarehouseItem', 'url'=>array('index')),
//	array('label'=>'Manage SupWarehouseItem', 'url'=>array('admin')),
);
?>

<h1>Create SupWarehouseItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'sup_id'=>$sup_id)); ?>