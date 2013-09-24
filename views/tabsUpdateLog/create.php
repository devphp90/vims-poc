<?php
$this->breadcrumbs=array(
	'Tabs Update Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TabsUpdateLog','url'=>array('index')),
	array('label'=>'Manage TabsUpdateLog','url'=>array('admin')),
);
?>

<h1>Create TabsUpdateLog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>