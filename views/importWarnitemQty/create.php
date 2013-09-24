<?php
$this->breadcrumbs=array(
	'Import Warnitem Qties'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportWarnitemQty','url'=>array('index')),
	array('label'=>'Manage ImportWarnitemQty','url'=>array('admin')),
);
?>

<h1>Create ImportWarnitemQty</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>