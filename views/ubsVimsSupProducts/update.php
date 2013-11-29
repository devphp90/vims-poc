<?php
$this->breadcrumbs=array(
	'Ubs Vims Sup Products'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsVimsSupProducts','url'=>array('index')),
	array('label'=>'Create UbsVimsSupProducts','url'=>array('create')),
	array('label'=>'View UbsVimsSupProducts','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UbsVimsSupProducts','url'=>array('admin')),
);
?>

<h1>Update UbsVimsSupProducts <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>