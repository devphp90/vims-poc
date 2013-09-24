<?php
/* @var $this ImportSupItemBufferRuleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Sup Item Buffer Rules',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import Sup Item Buffer Rules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
