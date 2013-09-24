<?php
$this->breadcrumbs=array(
	'Import Vsheet Lasts',
);

$this->menu=array(
	array('label'=>'Create ImportVsheetLast','url'=>array('create')),
	array('label'=>'Manage ImportVsheetLast','url'=>array('admin')),
);
?>

<h1>Import Vsheet Lasts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
