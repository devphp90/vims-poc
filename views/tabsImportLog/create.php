<?php
$this->breadcrumbs=array(
	'Tabs Import Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TabsImportLog','url'=>array('index')),
	array('label'=>'Manage TabsImportLog','url'=>array('admin')),
);
?>

<h1>Create TabsImportLog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>