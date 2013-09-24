<?php
/* @var $this ImportFileTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import File Types',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import File Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
