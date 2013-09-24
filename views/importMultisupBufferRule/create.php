<?php
/* @var $this ImportMultisupBufferRuleController */
/* @var $model ImportMultisupBufferRule */

$this->breadcrumbs=array(
	'Import Multisup Buffer Rules'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create ImportMultisupBufferRule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>