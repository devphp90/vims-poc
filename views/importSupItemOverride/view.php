<?php
$this->breadcrumbs=array(
	'Import Sup Item Overrides'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'Update ','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ','url'=>array('admin')),
);
?>

<h1>View  #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sup_id',
		'supitem_id',
		'start',
		'end',
    'qty',
		'comment',
		'create_time',
		'update_time',
		'create_by',
		'update_by',
	),
)); ?>
