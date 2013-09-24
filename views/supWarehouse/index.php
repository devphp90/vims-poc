<?php
$this->breadcrumbs=array(
	'Sup Warehouses',
);

$this->menu=array(
	array('label'=>'Create SupWarehouse', 'url'=>array('create')),
	array('label'=>'Manage SupWarehouse', 'url'=>array('admin')),
);
?>

<h1>Sup Warehouses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
