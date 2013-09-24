<?php
/* @var $this ImportSheetTypeController */
/* @var $model ImportSheetType */

$this->breadcrumbs=array(
	'Import Sheet Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportSheetType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>