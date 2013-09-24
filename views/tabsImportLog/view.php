<?php
$this->breadcrumbs=array(
	'Tabs Import Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TabsImportLog','url'=>array('index')),
	array('label'=>'Create TabsImportLog','url'=>array('create')),
	array('label'=>'Update TabsImportLog','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TabsImportLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TabsImportLog','url'=>array('admin')),
);
?>

<h1>View TabsImportLog #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tabs_id',
		'download_sheet1_status',
		'download_sheet1_reason',
		'download_sheet2_status',
		'download_sheet2_reason',
		'data_integrity_status',
		'data_integrity_reason',
		'overall_item_status',
		'overall_item_reason',
		'create_time',
		'finish_time',
		'status',
	),
)); ?>
