<?php
$this->breadcrumbs=array(
	'Import Warnitem Prices',
);

$this->menu=array(
	array('label'=>'Create ImportWarnitemPrice','url'=>array('create')),
	array('label'=>'Manage ImportWarnitemPrice','url'=>array('admin')),
);
?>

<h1>Import Warnitem Prices</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
