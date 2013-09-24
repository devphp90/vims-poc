<?php
$this->breadcrumbs=array(
	'Tabs Update Logs',
);

$this->menu=array(
	array('label'=>'Create TabsUpdateLog','url'=>array('create')),
	array('label'=>'Manage TabsUpdateLog','url'=>array('admin')),
);
?>

<h1>Tabs Update Logs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
