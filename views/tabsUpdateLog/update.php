<?php
$this->breadcrumbs=array(
	'Tabs Update Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TabsUpdateLog','url'=>array('index')),
	array('label'=>'Create TabsUpdateLog','url'=>array('create')),
	array('label'=>'View TabsUpdateLog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TabsUpdateLog','url'=>array('admin')),
);
?>

<h1>Update TabsUpdateLog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>