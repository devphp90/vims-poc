<?php
$this->breadcrumbs = array(
    'Import Vsheets' => array('index'),
    'Manage',
);



$this->menu = array(
    array('label' => 'Search/Filter', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
);



Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('import-vsheet-grid', {

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


<h1>vSheet: <?php echo $supName ?>
<span style="font-weight: normal; font-size: 15px; margin-left: 20px;">UBS Supplier ID: <b>
<?php echo $tabsModel->supplier->ubs_supplier_id ?>
</b> &nbsp;&nbsp;VIMS Supplier ID1: <b>
<?php echo $tabsModel->supplier_id ?></b> 
&nbsp;&nbsp;VIMS Supplier ID2: 
<b><?php echo $tabsModel->id ?></b>
</span>

</h1>



<div class="search-form" style="display:none">

    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>

</div><!-- search-form -->



<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id' => 'import-vsheet-grid',
    'dataProvider' => $model->supsearch($id),
    'filter' => $model,
    'fixedHeader' => true,
    'headerOffset' => 61,
    'columns' => array(
        array(
            'name' => 'sup_vsku',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'name' => 'mfg_sku',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
		 array(
            'name' => 'upc',
            'htmlOptions' => array('style' => 'width: 160px;'),
            'headerHtmlOptions' => array('style' => 'width: 160px'),
        ),
        array(
            'name' => 'mfg_name',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
		
        array(
            'header' => 'Mfg<br/>Part<br/>Name',
            'name' => 'mfg_part_name',
        ),
        'price',
        'map',
        array(
            'header' => 'is From sheet 2?',
            'value' => '$data->sheet_type?"y":"n"',
        ),
        'ware_1',
        'ware_2',
        'ware_3',
        'ware_4',
        'ware_5',
        'ware_6',
      
        'sup_sku_name',
      /*  array(
            'header' => 'VIMS<br/>Supp<br/>ID1',
            'type' => 'raw',
            'name' => 'sup_id',
            'value' => 'CHtml::link($data->importRoutine->supplier->name,array("/supplier/".$data->importRoutine->supplier->id)).\'<br/>\'.$data->importRoutine->supplier->id',
        ),
        array(
            'header' => 'VIMS<br/>Supp<br/>ID2',
            'name' => 'id',
        ),
        array(
            'name' => 'supplier.ubs_supplier_id',
            'header' => 'UBS<br/>Supp<br/>ID',
            'value' => '$data->supplier->ubs_supplier_id',
        ),
		*/
        array(
            'header' => 'Import<br/>ID',
            'name' => 'import_id',
            'type' => 'raw',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>

