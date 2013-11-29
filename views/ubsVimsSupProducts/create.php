<?php
$this->breadcrumbs=array(
	'Ubs Vims Sup Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UbsVimsSupProducts','url'=>array('index')),
	array('label'=>'Manage UbsVimsSupProducts','url'=>array('admin')),
);
?>

<h1>Create UbsVimsSupProducts</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>