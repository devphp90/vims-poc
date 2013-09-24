<?php
/* @var $this ImportSupMarkupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Sup Markups',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import Sup Markups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
