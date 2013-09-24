<?php
$this->breadcrumbs=array(
	'Tabs Main Logs',
);

$this->menu=array(
	array('label'=>'Create TabsMainLog','url'=>array('create')),
	array('label'=>'Manage TabsMainLog','url'=>array('admin')),
);
?>

<h1>Tabs Main Logs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
