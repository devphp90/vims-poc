<?php
$this->breadcrumbs=array(
	'Sup Failed Import Reasons',
);

$this->menu=array(
	array('label'=>'Create','url'=>array('create')),
	array('label'=>'Manage','url'=>array('admin')),
);
?>

<h1>Sup Failed Import Reasons</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
