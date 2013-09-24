<?php
$this->breadcrumbs=array(
	'Import Sup Item Overrides'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Manage ','url'=>array('admin')),
);
?>

<h1>Create User OverRide Supplier Qty, at Supplier Item Level</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>