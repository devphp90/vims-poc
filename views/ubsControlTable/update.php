<?php
$this->breadcrumbs=array(
	'Ubs Control Tables'=>array('index'),
	$model->TableId=>array('view','id'=>$model->TableId),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsControlTable','url'=>array('index')),
	array('label'=>'Create UbsControlTable','url'=>array('create')),
	array('label'=>'View UbsControlTable','url'=>array('view','id'=>$model->TableId)),
	array('label'=>'Manage UbsControlTable','url'=>array('admin')),
);
?>

<h1>Update UbsControlTable <?php echo $model->TableId; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>