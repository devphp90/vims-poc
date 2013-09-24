<?php
$this->breadcrumbs=array(
	'Tabs Import Logs',
);

$this->menu=array(
	array('label'=>'Create TabsImportLog','url'=>array('create')),
	array('label'=>'Manage TabsImportLog','url'=>array('admin')),
);
?>

<h1>Tabs Import Logs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
