<?php
$this->breadcrumbs=array(
	'Ubs Items Syncs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UbsItemsSync','url'=>array('index')),
	array('label'=>'Manage UbsItemsSync','url'=>array('admin')),
);
?>

<h1>Create UbsItemsSync</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>