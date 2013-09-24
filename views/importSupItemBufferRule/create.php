<?php
/* @var $this ImportSupItemBufferRuleController */
/* @var $model ImportSupItemBufferRule */

$this->breadcrumbs=array(
	'Import Sup Item Buffer Rules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportSupItemBufferRule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>