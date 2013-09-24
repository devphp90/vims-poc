<?php
$this->breadcrumbs = array(
    'Ubs Open Orders' => array('index'),
    $model->Name,
);

$this->menu = array(
    array('label' => 'List ', 'url' => array('index')),
    array('label' => 'Create ', 'url' => array('create')),
    array('label' => 'Update ', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete ', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>View UbsOpenOrder #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'Cancelled',
        'ItemNumber',
        'Product',
        'QuantityOrdered',
        'Approved',
        'ApprovalDate',
        'OrderNumber',
        'OrderDate',
        'Name',
        'SupplierName',
        'Phone',
        'Email',
        'SKU',
        'Suppliers_SupplierID',
        'CartID',
    ),
)); ?>
