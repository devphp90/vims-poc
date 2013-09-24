<?php
$this->breadcrumbs=array(
	'Tabs Import Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TabsImportLog','url'=>array('index')),
	array('label'=>'Create TabsImportLog','url'=>array('create')),
	array('label'=>'View TabsImportLog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TabsImportLog','url'=>array('admin')),
);
?>

<h1>Update TabsImportLog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>