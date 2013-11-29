<?php
$this->breadcrumbs=array(
	'Ubs Supplier Item Seeds',
);

$this->menu=array(
	array('label'=>'Create UbsSupplierItemSeed','url'=>array('create')),
	array('label'=>'Manage UbsSupplierItemSeed','url'=>array('admin')),
);
?>

<h1>Ubs Supplier Item Seeds</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
