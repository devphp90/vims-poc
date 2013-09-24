<?php
$this->breadcrumbs=array(
	'Tabs Update Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TabsUpdateLog','url'=>array('index')),
	array('label'=>'Create TabsUpdateLog','url'=>array('create')),
	array('label'=>'Update TabsUpdateLog','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TabsUpdateLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TabsUpdateLog','url'=>array('admin')),
);
?>

<h1>View TabsUpdateLog #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tabs_id',
		'data_integrity_status',
		'data_integrity_reason',
		'qoh_item_percent_change_status',
		'qoh_item_percent_change_reason',
		'price_item_percent_change_status',
		'price_item_percent_change_reason',
		'instock_item_status',
		'instock_item_reason',
		'qoh_percent_change_status',
		'qoh_percent_change_reason',
		'price_percent_change_status',
		'price_percent_change_reason',
	),
)); ?>
