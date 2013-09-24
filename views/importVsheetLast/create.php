<?php
$this->breadcrumbs=array(
	'Import Vsheet Lasts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportVsheetLast','url'=>array('index')),
	array('label'=>'Manage ImportVsheetLast','url'=>array('admin')),
);
?>

<h1>Create ImportVsheetLast</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>