<?php
$this->breadcrumbs=array(
	'Import Warnitem Prices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportWarnitemPrice','url'=>array('index')),
	array('label'=>'Create ImportWarnitemPrice','url'=>array('create')),
	array('label'=>'View ImportWarnitemPrice','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ImportWarnitemPrice','url'=>array('admin')),
);
?>

<h1>Update ImportWarnitemPrice <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>