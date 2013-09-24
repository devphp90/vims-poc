<?php
$this->breadcrumbs=array(
	'Ubs Items Syncs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UbsItemsSync','url'=>array('index')),
	array('label'=>'Create UbsItemsSync','url'=>array('create')),
	array('label'=>'Update UbsItemsSync','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UbsItemsSync','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	
);
?>

<h1>View UbsItemsSync #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sku',
		'name',
		'manufacturer',
		'manufacturer_part_number',
		'upc',
		'our_cost',
	),
)); ?>
