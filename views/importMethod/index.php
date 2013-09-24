<?php
/* @var $this ImportMethodController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Methods',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import Methods</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
