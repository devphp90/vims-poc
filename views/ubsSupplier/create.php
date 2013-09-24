<?php
$this->breadcrumbs=array(
	'Ubs Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
);
?>

<h1>Create UbsSupplier</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>