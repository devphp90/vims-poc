<?php
/* @var $this ImportRoutineServerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Routine Servers',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Import Routine Servers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
