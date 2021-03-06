<?php
$this->breadcrumbs = array(

    'Sup New Items' => array('index'),

    'Manage',

);


$this->menu = array(

    array('label' => 'Search/Filter', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
    array('label' => 'Delete All', 'url' => '#', 'linkOptions' => array('submit' => array('deleteAllNoMatch?id=' .(isset($supplier) ? $supplier->id : "")),
        'confirm' => 'Are you sure you want to delete all item?')),
    array('label' => 'Export CSV', 'url' => Yii::app()->createUrl('/supNewItem/noMatchExport', array('type' => 'csv'))),
    array('label' => 'Export Excel', 'url' => Yii::app()->createUrl('/supNewItem/noMatchExport', array('type' => 'excel'))),

);


Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('sup-new-item-grid', {

		data: $(this).serialize()

	});

	return false;

});

");
?>
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

<?php if ($supplier): ?>
<h1>No Match New Items for Supplier: <?= $supplier->name; ?></h1>
<?php else: ?>
<h1>No Match New Items for ALL Suppliers</h1>
<?php endif; ?>





<div class="search-form" style="display:none">


    <?php /*$this->renderPartial('_search',array(

	'model'=>$model,

)); */?>

</div><!-- search-form -->



<?php $this->widget('bootstrap.widgets.TbGridView', array(

    'id' => 'sup-new-item-grid',

    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'filter' => $model,

    'columns' => array(

        array(

            'header' => 'vSKU',

            'name' => 'sup_vsku'
        ),

        array(
            'header' => 'Supplier',
            'name' => 'supplierName',
            'type' => 'raw',
            //'value'=>'$data->supplier->name.\'<br/>\'.$data->import_routine->sup_id',
            'value' => '$data->supplier->name',
        ),

        'mfg_name',
        'mfg_sku_name',

        array(

            'header' => 'MPN',

            'name' => 'mfg_sku',
        ),

        array(

            'header' => 'UPC',

            'name' => 'mfg_upc',
        ),

        array(

            'header' => 'Supp<br/>Item<br/>Price',
            'name' => 'sup_price',
            'htmlOptions' => array(
                'style' => 'width:30px;',
            ),
        ),


        'sup_sku',
        'sup_sku_name',
        'sup_description',

        array(
            'header' => 'UBS SKU<br/>when MisMatch',
            'value' => '$data->ubsInventory->sku',
            'htmlOptions' => array('style' => 'width: 150px'),
            'headerHtmlOptions' => array('style' => 'width: 150px'),
        ),
		
		
			
		array(
			'header'=>'VIMS Supp ID1',
			'name'=>'sup_id',
		),
		array(
			'header'=>'VIMS Supp ID2',
			'name'=>'tabs.id',
		),
		array(
			'header'=>'UBS Supp ID',
			'name'=>'supplier.ubs_supplier_id',
		),

		
		
        'id',
        array(

            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("supNewItem/deleteNoMatch/$data->id")',
            'htmlOptions' => array(
                'style' => 'width:10px;',
            ),

        ),
        /*array(

            'class'=>'CButtonColumn',

        ),*/

    ),

)); ?>


