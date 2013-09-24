<?php
/* @var $this LogsDetailController */
/* @var $model LogsDetail */

$this->breadcrumbs=array(
	'Logs Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LogsDetail', 'url'=>array('index')),
	array('label'=>'Manage LogsDetail', 'url'=>array('admin')),
);
?>

<h1>Create LogsDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>