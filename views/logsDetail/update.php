<?php
/* @var $this LogsDetailController */
/* @var $model LogsDetail */

$this->breadcrumbs=array(
	'Logs Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LogsDetail', 'url'=>array('index')),
	array('label'=>'Create LogsDetail', 'url'=>array('create')),
	array('label'=>'View LogsDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LogsDetail', 'url'=>array('admin')),
);
?>

<h1>Update LogsDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>