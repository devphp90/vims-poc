<?php
$this->breadcrumbs=array(
	'Ubs Supplier Stats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
);
?>

<h1>Create UbsSupplierStat</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>