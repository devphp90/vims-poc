<?php
$this->breadcrumbs=array(
	'Supp Vsheet Dups'=>array('index'),
	'Create',
);

$this->menu=array(

	array('label'=>'Manage ','url'=>array('admin')),
);
?>

<h1>Create SuppVsheetDup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>