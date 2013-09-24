<?php
$this->breadcrumbs=array(
	'Import Warnitem Qties',
);

$this->menu=array(
	array('label'=>'Create ImportWarnitemQty','url'=>array('create')),
	array('label'=>'Manage ImportWarnitemQty','url'=>array('admin')),
);
?>

<h1>Import Warnitem Qties</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
