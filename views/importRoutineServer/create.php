<?php
/* @var $this ImportRoutineServerController */
/* @var $model ImportRoutineServer */

$this->breadcrumbs=array(
	'Import Routine Servers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportRoutineServer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>