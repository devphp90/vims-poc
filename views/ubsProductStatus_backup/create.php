<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
);
?>

<h1>Create UbsProductStatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>