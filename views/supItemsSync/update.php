<?php
$this->breadcrumbs=array(
	'Sup Items Syncs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'View ','url'=>array('view','id'=>$model->id)),
);
?>

<h1>Update SupItemsSync <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>