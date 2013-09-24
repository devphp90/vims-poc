<?php
/* @var $this UbsPercentageRuleController */
/* @var $model UbsPercentageRule */

$this->breadcrumbs=array(
	'Difference In Cost Percentage Rule'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Create Difference In Cost Percentage Rule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>