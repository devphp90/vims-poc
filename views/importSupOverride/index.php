<?php
$this->breadcrumbs=array(
	'Import Sup Overrides',
);

$this->menu=array(
	array('label'=>'Create ImportSupOverride','url'=>array('create')),
	array('label'=>'Manage ImportSupOverride','url'=>array('admin')),
);
?>

<h1>Import Sup Overrides</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
