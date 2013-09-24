<?php
/* @var $this UpdateQaSupplierController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Update QA Suppliers',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Update QA Suppliers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
