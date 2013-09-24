<?php
$this->breadcrumbs=array(
	'Sup Items Syncs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'Update ','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View SupItemsSync #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'UbsSupplierName',
		'UbsSupplierID',
        'UbsSku',
		'Mpn',
		'Upc',
		'SupplierSku',
		'ItemName',
	),
)); ?>
