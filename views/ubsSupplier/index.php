<?php
$this->breadcrumbs=array(
	'Ubs Suppliers',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
);
?>

<h1>Ubs Suppliers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
