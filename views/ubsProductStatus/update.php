<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsProductStatus','url'=>array('index')),
	array('label'=>'Create UbsProductStatus','url'=>array('create')),
	array('label'=>'View UbsProductStatus','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UbsProductStatus','url'=>array('admin')),
);
?>

<h1>Update UbsProductStatus <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>