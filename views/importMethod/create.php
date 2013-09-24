<?php
/* @var $this ImportMethodController */
/* @var $model ImportMethod */

$this->breadcrumbs=array(
	'Import Methods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportMethod</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>