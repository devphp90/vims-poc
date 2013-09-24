<?php
$this->breadcrumbs=array(
	'Import Vsheets',
);

$this->menu=array(
	array('label'=>'Create ImportVsheet','url'=>array('create')),
	array('label'=>'Manage ImportVsheet','url'=>array('admin')),
);
?>

<h1>Import Vsheets</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
