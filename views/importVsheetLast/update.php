<?php
$this->breadcrumbs=array(
	'Import Vsheet Lasts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportVsheetLast','url'=>array('index')),
	array('label'=>'Create ImportVsheetLast','url'=>array('create')),
	array('label'=>'View ImportVsheetLast','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ImportVsheetLast','url'=>array('admin')),
);
?>

<h1>Update ImportVsheetLast <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>