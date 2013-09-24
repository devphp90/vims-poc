<?php
$this->breadcrumbs=array(
	'Ubs Open Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
);
?>

<h1>Create UbsOpenOrder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>