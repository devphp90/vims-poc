<?php
/* @var $this ImportSupMarkupController */
/* @var $model ImportSupMarkup */

$this->breadcrumbs=array(
	'Import Sup Markups'=>array('index'),
	'Create',
);

$this->menu=array(
	// array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create Supplier Level Price Markup and Break MAP Rules</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>