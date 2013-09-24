<?php
/* @var $this WizardsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sup Setup',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Supplier Setups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
