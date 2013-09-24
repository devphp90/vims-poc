<?php
/* @var $this LogsDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Logs Details',
);

$this->menu=array(
	array('label'=>'Create LogsDetail', 'url'=>array('create')),
	array('label'=>'Manage LogsDetail', 'url'=>array('admin')),
);
?>

<h1>Logs Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
