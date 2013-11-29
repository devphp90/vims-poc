<?php
$this->breadcrumbs=array(
	'Ubs Vims Ubs Products'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UbsVimsUbsProduct','url'=>array('index')),
	array('label'=>'Create UbsVimsUbsProduct','url'=>array('create')),
	array('label'=>'Update UbsVimsUbsProduct','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UbsVimsUbsProduct','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UbsVimsUbsProduct','url'=>array('admin')),
);
?>

<h1>View UbsVimsUbsProduct #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ubs_sku',
		'primary_supplier_ubs_id',
		'primary_supplier_vims_id',
		'primary_supplier_vsheet_mpn',
		'primary_supplier_vsheet_upc',
		'primary_supplier_vsheet_manufacturer',
		'primary_supplier_vsheet_item_description',
		'primary_supplier_vsheet_price',
		'primary_supplier_vsheet_map_price',
		'primary_supplier_vsheet_our_cost',
		'primary_supplier_vsheet_qoh',
		'primary_supplier_vsheet_sku',
		'sale_price',
		'sale_qoh',
		'dtCreated',
	),
)); ?>
