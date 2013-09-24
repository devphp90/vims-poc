<?php
$this->breadcrumbs=array(
	'Supplier Setup'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	array('label'=>'Manage','url'=>array('admin')),
);
?>

<h1>Create Supplier Setup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>