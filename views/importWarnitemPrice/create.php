<?php
$this->breadcrumbs=array(
	'Import Warnitem Prices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportWarnitemPrice','url'=>array('index')),
	array('label'=>'Manage ImportWarnitemPrice','url'=>array('admin')),
);
?>

<h1>Create ImportWarnitemPrice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>