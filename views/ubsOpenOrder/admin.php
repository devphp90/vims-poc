<?php
$this->breadcrumbs = array(
    'List' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List ', 'url' => array('index')),
    array('label' => 'Create ', 'url' => array('create')),

);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-open-order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Open Orders</h1>

<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'ubs-open-order-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'Name',
        'SupplierName',
        'Phone',
        'Email',
        'SKU',
        'Suppliers_SupplierID',
        'CartID',
        'ItemNumber',
        'Product',
        'QuantityOrdered',
        'OrderNumber',
        'OrderDate',
        /*
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
        */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
