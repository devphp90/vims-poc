<?php
/* @var $this ImportMultisupBufferRuleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Multisup Buffer Rules',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import Multisup Buffer Rules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
