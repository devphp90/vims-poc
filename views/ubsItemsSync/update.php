<?php
$this->breadcrumbs=array(
	'Ubs Items Syncs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UbsItemsSync','url'=>array('index')),
	array('label'=>'Create UbsItemsSync','url'=>array('create')),
	array('label'=>'View UbsItemsSync','url'=>array('view','id'=>$model->id)),

);
?>

<h1>Update UbsItemsSync <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>