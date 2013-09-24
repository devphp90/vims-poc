<?php
$this->breadcrumbs=array(
	'Sup Warehouse Items',
);

$this->menu=array(
	array('label'=>'Create SupWarehouseItem', 'url'=>array('create')),
	array('label'=>'Manage SupWarehouseItem', 'url'=>array('admin')),
);
?>

<h1>Sup Warehouse Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
