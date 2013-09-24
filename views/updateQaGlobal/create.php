<?php
/* @var $this UpdateQaGlobalController */
/* @var $model UpdateQaGlobal */

$this->breadcrumbs=array(
	'Update QA Globals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create UpdateQAGlobal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>