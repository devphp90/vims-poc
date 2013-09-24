<?php
$this->breadcrumbs=array(
	'Ubs Open Orders',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
);
?>

<h1>Ubs Open Orders</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
