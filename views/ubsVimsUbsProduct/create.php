<?php
$this->breadcrumbs=array(
	'Ubs Vims Ubs Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UbsVimsUbsProduct','url'=>array('index')),
	array('label'=>'Manage UbsVimsUbsProduct','url'=>array('admin')),
);
?>

<h1>Create UbsVimsUbsProduct</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>