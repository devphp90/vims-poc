<?php
$this->breadcrumbs=array(
	'Import Sup Item Overrides',
);

$this->menu=array(
	array('label'=>'Create ImportSupItemOverride','url'=>array('create')),
	array('label'=>'Manage ImportSupItemOverride','url'=>array('admin')),
);
?>

<h1>Import Sup Item Overrides</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
