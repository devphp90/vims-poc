<?php
$this->breadcrumbs=array(
	'Sup Warehouses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create SupWarehouse</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>