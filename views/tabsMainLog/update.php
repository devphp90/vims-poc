<?php
$this->breadcrumbs=array(
	'Tabs Main Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TabsMainLog','url'=>array('index')),
	array('label'=>'Create TabsMainLog','url'=>array('create')),
	array('label'=>'View TabsMainLog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TabsMainLog','url'=>array('admin')),
);
?>

<h1>Update TabsMainLog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>