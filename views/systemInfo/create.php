<?php
/* @var $this SystemInfoController */
/* @var $model SystemInfo */

$this->breadcrumbs=array(
	'System Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create SystemInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>