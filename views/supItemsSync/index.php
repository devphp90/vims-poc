<?php
$this->breadcrumbs=array(
	'Sup Items Syncs',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
);
?>

<h1>Sup Items Syncs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
