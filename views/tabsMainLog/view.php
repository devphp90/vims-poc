<?php
$this->breadcrumbs=array(
	'Tabs Main Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TabsMainLog','url'=>array('index')),
	array('label'=>'Create TabsMainLog','url'=>array('create')),
	array('label'=>'Update TabsMainLog','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TabsMainLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TabsMainLog','url'=>array('admin')),
);
?>

<h1>View TabsMainLog #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tabs_id',
		'sheet1_file_size',
		'sheet2_file_size',
		'sheet1_row',
		'sheet2_row',
		'create_time',
		'update_time',
		'status',
	),
)); ?>
