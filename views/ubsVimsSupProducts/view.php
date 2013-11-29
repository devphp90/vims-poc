<?php
$this->breadcrumbs=array(
	'Ubs Vims Sup Products'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UbsVimsSupProducts','url'=>array('index')),
	array('label'=>'Create UbsVimsSupProducts','url'=>array('create')),
	array('label'=>'Update UbsVimsSupProducts','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UbsVimsSupProducts','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UbsVimsSupProducts','url'=>array('admin')),
);
?>

<h1>View UbsVimsSupProducts #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'action',
		'ubs_sku',
		'supplier_ubs_id',
		'supplier_name',
		'mpn',
		'upc',
		'supplier_sku',
		'ubs_manufacturer',
		'item_description',
		'our_cost',
		'qoh',
		'dtCreated',
	),
)); ?>
