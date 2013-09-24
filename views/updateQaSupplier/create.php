<?php
/* @var $this UpdateQaSupplierController */
/* @var $model UpdateQaSupplier */

$this->breadcrumbs=array(
	'Update QA Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create UpdateQASupplier</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>