<?php
$this->breadcrumbs=array(
	'Ubs Control Tables',
);

$this->menu=array(
	array('label'=>'Create UbsControlTable','url'=>array('create')),
	array('label'=>'Manage UbsControlTable','url'=>array('admin')),
);
?>

<h1>Ubs Control Tables</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
