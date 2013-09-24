<?php
$this->breadcrumbs=array(
	'Supplier Setup',
);

$this->menu=array(
	array('label'=>'Create','url'=>array('create')),
	array('label'=>'Manage','url'=>array('admin')),
);
?>

<h1>Supplier Setup</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
