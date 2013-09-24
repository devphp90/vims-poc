<?php
$this->breadcrumbs = array(
    'Email Suppliers',
);

$this->menu = array(
    array('label' => 'Create EmailSuppliers', 'url' => array('create')),
    array('label' => 'Manage EmailSuppliers', 'url' => array('admin')),
);
?>

<h1>Email Suppliers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
