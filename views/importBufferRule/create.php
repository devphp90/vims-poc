<?php
$this->breadcrumbs=array(
	'Import Buffer Rules'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportBufferRule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>