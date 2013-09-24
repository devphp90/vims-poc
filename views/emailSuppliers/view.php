<?php
$this->breadcrumbs=array(
	'Email Suppliers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmailSuppliers','url'=>array('index')),
	array('label'=>'Create EmailSuppliers','url'=>array('create')),
	array('label'=>'Update EmailSuppliers','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete EmailSuppliers','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmailSuppliers','url'=>array('admin')),
);
?>

<h1>View EmailSuppliers #<?php echo $model->id; ?></h1>

<?php /*$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'supplier_id',
		'content',
	),
)); */?>
<?php
if ($heading) {
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $dataProvider,
        'template' => "{items}",
        'columns' => $heading
    ));
} else {
    echo "Not able to parse.";
}
?>
