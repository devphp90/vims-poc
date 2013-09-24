<?php
/* @var $this SupInventoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sup Inventories',
);

$this->menu=array(
	array('label'=>'Create SupInventory', 'url'=>array('create')),
	array('label'=>'Manage SupInventory', 'url'=>array('admin')),
);
?>

<h1>Sup Inventories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
