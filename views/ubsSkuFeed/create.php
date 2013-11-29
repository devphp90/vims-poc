<?php
$this->breadcrumbs=array(
	'Ubs Sku Feeds'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List UbsSkuFeed','url'=>array('index')),
	array('label'=>'Manage','url'=>array('admin')),
);
?>

<h1>Create UbsSkuFeed</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>