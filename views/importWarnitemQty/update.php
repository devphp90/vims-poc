<?php
$this->breadcrumbs=array(
	'Import Warnitem Qties'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportWarnitemQty','url'=>array('index')),
	array('label'=>'Create ImportWarnitemQty','url'=>array('create')),
	array('label'=>'View ImportWarnitemQty','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ImportWarnitemQty','url'=>array('admin')),
);
?>

<h1>Update ImportWarnitemQty <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>