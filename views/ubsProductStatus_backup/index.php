<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
);
?>

<h1>Ubs Product Statuses</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
