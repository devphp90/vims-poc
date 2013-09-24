<?php
$this->breadcrumbs=array(
	'Sup Items Syncs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
);
?>

<h1>Create SupItemsSync</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>