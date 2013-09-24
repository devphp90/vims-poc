<?php
/* @var $this ImportFileTypeController */
/* @var $model ImportFileType */

$this->breadcrumbs=array(
	'Import File Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportFileType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>