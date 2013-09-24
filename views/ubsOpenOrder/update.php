<?php
$this->breadcrumbs=array(
	'Ubs Open Orders'=>array('index'),
	$model->Name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'View ','url'=>array('view','id'=>$model->id)),
);
?>

<h1>Update UbsOpenOrder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>