<?php
$this->breadcrumbs=array(
	'Ubs Supplier Stats',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
);
?>

<h1>Ubs Supplier Stats</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
