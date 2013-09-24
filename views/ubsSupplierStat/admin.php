<?php
$this->breadcrumbs = array(
    'Ubs Supplier Stats' => array('index'),
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
	$.fn.yiiGridView.update('ubs-supplier-stat-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Supplier Stats</h1>


<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'ubs-supplier-stat-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'SupplierId',
        'SupplierName',
        'OrderCount',
        'OrderCount_Last30Days',
        'Shipdays_OrderCount',
        'ShipDays',
        'ShipDays_AllUnder30',
        'BusinessShipDays',
        'BusinessShipDays_allunder30',
        'ShipDays_Last30Days',
        'CancelOrderCount',
        'CancelRate',
        'CancelRate_Last30Days',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
