<?php
/* @var $this ImportSupBufferRuleController */
/* @var $model ImportSupBufferRule */

$this->breadcrumbs=array(
	'Import Sup Buffer Rules'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportSupBufferRule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>