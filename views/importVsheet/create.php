<?php
$this->breadcrumbs=array(
	'Import Vsheets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportVsheet','url'=>array('index')),
	array('label'=>'Manage ImportVsheet','url'=>array('admin')),
);
?>

<h1>Create ImportVsheet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>