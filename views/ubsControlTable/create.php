<?php
$this->breadcrumbs=array(
	'Ubs Control Tables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UbsControlTable','url'=>array('index')),
	array('label'=>'Manage UbsControlTable','url'=>array('admin')),
);
?>

<h1>Create UbsControlTable</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>