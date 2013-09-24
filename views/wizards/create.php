<?php
/* @var $this WizardsController */
/* @var $model Wizards */

$this->breadcrumbs=array(
	'Sup Setup'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create Supplier Setups</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>