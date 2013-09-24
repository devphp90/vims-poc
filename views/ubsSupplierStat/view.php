<?php
$this->breadcrumbs=array(
	'Ubs Supplier Stats'=>array('index'),
	$model->SupplierId,
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'Update ','url'=>array('update','id'=>$model->SupplierId)),
	array('label'=>'Delete ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->SupplierId),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View UbsSupplierStat #<?php echo $model->SupplierId; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'SupplierId',
		'SupplierName',
		'OrderCount',
		'OrderCount_Last30Days',
		'Shipdays_OrderCount',
		'ShipDays',
		'ShipDays_AllUnder30',
		'BusinessShipDays',
		'BusinessShipDays_allunder30',
		'ShipDays_Last30Days',
		'CancelOrderCount',
		'CancelRate',
		'CancelRate_Last30Days',
	),
)); ?>
