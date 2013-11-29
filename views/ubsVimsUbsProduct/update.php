<?php
$this->breadcrumbs=array(
	'Ubs Vims Ubs Products'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsVimsUbsProduct','url'=>array('index')),
	array('label'=>'Create UbsVimsUbsProduct','url'=>array('create')),
	array('label'=>'View UbsVimsUbsProduct','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UbsVimsUbsProduct','url'=>array('admin')),
);
?>

<h1>Update UbsVimsUbsProduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>