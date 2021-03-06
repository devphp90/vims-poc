<?php
/* @var $this ImportFileTypeController */
/* @var $model ImportFileType */

$this->breadcrumbs=array(
	'Import File Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Update ImportFileType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>