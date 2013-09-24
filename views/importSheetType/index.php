<?php
/* @var $this ImportSheetTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Sheet Types',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import Sheet Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
