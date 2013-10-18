<style>
.grid-view .summary {
    float: right;
    margin-bottom: 5px;
    position: absolute;
    right: 62px;
    text-align: right;
    top: 152px;
    width: 249px;
}
</style>
<?php
$this->breadcrumbs = array(
    'Supp Vsheet Dups' => array('index'),
    'Manage',
);

$this->menu = array(
//    array('label' => 'List ', 'url' => array('index')),
//    array('label' => 'Create ', 'url' => array('create')),
    array(
        'label' => 'Help', 
        'url' => '#', 
        'linkOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#help',
        ),
    )
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('supp-vsheet-dup-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Supplier vSheet Duplicate Items</h1>
<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
</div>-->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'supp-vsheet-dup-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'Supplier',
            'name' => 'supplierName',
            'type' => 'raw',
            //'value'=>'$data->supplier->name.\'<br/>\'.$data->import_routine->sup_id',
            'value' => '$data->supplier->name',
        ),
        'sheet_type',
        'update_type',
        'sup_vsku',
        'price',
        'map',
        'ware_1',
        'ware_2',
        'ware_3',
        'ware_4',
        'ware_5',
        'ware_6',
        'mfg_sku',
        'mfg_name',
        'mfg_part_name',
        'upc',
        'sup_sku',
        'sup_sku_name',
        'import_id',
        array(
            'name' => 'sup_id',
            'header' => 'Sup Id',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'help')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
</div>


<div class="modal-body">
    <p>Duplicate item found in vSheet.</p>
    <p>The last Item of a duplicate set is the last Item Updated.</p>
</div>

<div class="modal-footer">

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Close',
    'url' => '#',
    'htmlOptions' => array('data-dismiss' => 'modal'),
));
?>
</div>
<?php $this->endWidget(); ?>
