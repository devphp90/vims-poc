<?php
$this->breadcrumbs=array(
	'Ubs Sku Feeds',
);

$this->menu=array(
	array('label'=>'Create UbsSkuFeed','url'=>array('create')),
	array('label'=>'Manage UbsSkuFeed','url'=>array('admin')),
);
?>

<h1>Ubs Sku Feeds</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
