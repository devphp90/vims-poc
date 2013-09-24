<?php
$this->breadcrumbs=array(
	'Ubs Suppliers'=>array('index'),
	$model->SupplierID,
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'Update ','url'=>array('update','id'=>$model->SupplierID)),
	array('label'=>'Delete ','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->SupplierID),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View UbsSupplier #<?php echo $model->SupplierID; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'SupplierID',
		'SupplierName',
		'Address1',
		'Address2',
		'City',
		'State',
		'Zip',
		'Country',
		'Email',
		'Fax',
		'Phone',
		'TollFreePhone',
		'MainContact',
		'MainContactPhone',
		'Phone_2',
		'TimeStamp',
		'Phone2',
	),
)); ?>
