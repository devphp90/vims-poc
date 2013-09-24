<?php
$this->breadcrumbs=array(
	'Tabs Main Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TabsMainLog','url'=>array('index')),
	array('label'=>'Manage TabsMainLog','url'=>array('admin')),
);
?>

<h1>Create TabsMainLog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>