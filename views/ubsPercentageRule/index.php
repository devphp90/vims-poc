<?php
/* @var $this UbsPercentageRuleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Difference In Cost Percentage Rule',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Difference In Cost Percentage Rule</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
