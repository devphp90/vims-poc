<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List UbsProductStatus','url'=>array('index')),
	array('label'=>'Manage','url'=>array('admin')),
);
?>

<h1>Create UbsProductStatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>