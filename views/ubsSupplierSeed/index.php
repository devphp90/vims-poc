<?php
$this->breadcrumbs=array(
	'Ubs Supplier Seeds',
);

$this->menu=array(
	array('label'=>'Create UbsSupplierSeed','url'=>array('create')),
	array('label'=>'Manage UbsSupplierSeed','url'=>array('admin')),
);
?>

<h1>Ubs Supplier Seeds</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
