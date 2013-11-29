<?php
$this->breadcrumbs=array(
	'Ubs Vims Sup Products',
);

$this->menu=array(
	array('label'=>'Create UbsVimsSupProducts','url'=>array('create')),
	array('label'=>'Manage UbsVimsSupProducts','url'=>array('admin')),
);
?>

<h1>Ubs Vims Sup Products</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
