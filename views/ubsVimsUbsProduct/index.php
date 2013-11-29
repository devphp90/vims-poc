<?php
$this->breadcrumbs=array(
	'Ubs Vims Ubs Products',
);

$this->menu=array(
	array('label'=>'Create UbsVimsUbsProduct','url'=>array('create')),
	array('label'=>'Manage UbsVimsUbsProduct','url'=>array('admin')),
);
?>

<h1>Ubs Vims Ubs Products</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
