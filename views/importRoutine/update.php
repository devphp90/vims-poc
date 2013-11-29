<?php
$this->breadcrumbs=array(
	'Import Routine'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage', 'url'=>array('admin')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'List', 'url'=>array('index')),
);

?>

<h2>Update Supplier Import Routines <?php echo $model->id,' - ',$model->supplier->name; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>