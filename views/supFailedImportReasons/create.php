<?php
$this->breadcrumbs=array(
	'Sup Failed Import Reasons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	array('label'=>'Manage','url'=>array('admin')),
);
?>

<h1>Create Sup Failed Import Reasons</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>