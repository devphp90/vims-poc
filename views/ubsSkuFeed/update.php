<?php
$this->breadcrumbs=array(
	'Ubs Sku Feeds'=>array('index'),
	$model->name=>array('view','id'=>$model->SKU),
	'Update',
);

$this->menu=array(
	//array('label'=>'List UbsSkuFeed','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'View ','url'=>array('view','id'=>$model->SKU)),
	array('label'=>'Manage ','url'=>array('admin')),
);
?>

<h1>Update UbsSkuFeed <?php echo $model->SKU; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>