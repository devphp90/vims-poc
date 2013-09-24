<?php
$this->breadcrumbs=array(
	'Import Vsheets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportVsheet','url'=>array('index')),
	array('label'=>'Create ImportVsheet','url'=>array('create')),
	array('label'=>'View ImportVsheet','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ImportVsheet','url'=>array('admin')),
);
?>

<h1>Update ImportVsheet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>