<?php
$this->breadcrumbs = array(
    'Supplier Inventory' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List', 'url' => array('index')),
    array('label' => 'Create', 'url' => array('create')),
    array('label' => 'Search/Filter', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
//  array('label'=>'Import Seed Sheet', 'url'=>'#','linkOptions'=>array('id'=>'link-import', 'data-toggle' => 'modal', 'data-target' => '#modal-import')),
    array('label' => 'Import Seed Sheet', 'url' => array('importSeedSheet')),
    array(
        'label' => 'Help',
        'url' => '#',
        'linkOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
        ),
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-inventory4-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<style>
    #egw0{
        float:left;
    }
</style>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
</div>


<div class="modal-body">
    Text here....
</div>

<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Close',
        'type' => 'primary',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>

<h1>Supplier Items: <?php echo Supplier::model()->findByPk($id)->name ?></h1>



<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'fixedHeader' => true,
    'headerOffset' => 61,
    'id' => 'ubs-inventory4-grid',
    'dataProvider' => $model->supview($id),
    'filter' => $model,
    'template' => "{summary}{items}{pager}",
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => 'Set to Inactive',
                'click' => 'js:function(checked){
					var values = [];
					checked.each(function(){
			        	values.push($(this).val());
		 			});
					$.ajax({
						url: "/index.php/supInventory/ajaxMultiItemStatus",
						data:{
							ids: values.join(","),
							action: 0,
						},
						success:function(){
							$("#ubs-inventory4-grid").yiiGridView("update");
						}
					});
				}'
            ),
            array(
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => 'Set to Active',
                'click' => 'js:function(checked){
					var values = [];
					checked.each(function(){
			        	values.push($(this).val());
		 			});
					$.ajax({
						url: "/index.php/supInventory/ajaxMultiItemStatus",
						data:{
							ids: values.join(","),
							action: 1,
						},
						success:function(){
							$("#ubs-inventory4-grid").yiiGridView("update");
						}
					});
				}'
            ),
        ),
        // if grid doesn't have a checkbox column type, it will attach
        // one and this configuration will be part of it
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),
    'columns' => array(
        'sup_vsku',
        array(
            'name' => 'ubs_sku',
            'type' => 'raw',
            'value' => 'CHtml::link($data->ubs_sku,array("/ubsInventory/admin?UbsInventory%5Bsku%5D=".$data->ubs_sku))',
        ),
        array(
            'name' => 'mfg_name',
        ),
        array(
            'name' => 'mfg_sku_name',
        ),
        array(
            'header' => 'User Item Status',
            'value' => '$data->item_status?"Active":"Inactive"',
        ),
        'uprice',
        'umap',
        'uqty',
        'sup_price',
        'sup_min_adv_price',
        array(
            'header' => 'VIMS<br/>Stock Status',
            'name' => 'sup_status',
            'type' => 'raw',
            //'value'=>'$data->sup_status?$data->sup_status==1?\'INSTOCK\':\'BO\':\'DISCO\'',
            'value' => 'CHtml::dropdownlist("sup_status",$data->sup_status,array(1=>"InStock", 0=>"BackOrdered", 3=>"Missing", 2=>"Discontinued"),array("class"=>"span2 editdropdown",":id"=>$data->id))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbRelationalColumn',
            'header' => 'sQTY<br/>Warehouse detail',
            'url' => $this->createUrl('/supWarehouseItem/ajaxItem'),
            'value' => '$data->qty_total_c',
            'filter' => false,
            'sortable' => false,
        ),
        'ibuffer_c',
        'sbuffer_c',
        'gbuffer_c',
        array(
            'header' => 'Apply Buffer',
            'value' => '$data->buffer_c',
        ),
        array(
            'name' => 'sup_bqoh_c',
        ),
        array(
            'name' => 'sup_open_order',
        ),
        array(
            'name' => 'sup_vqoh_c',
        ),
        'sup_sku',
        'mfg_sku',
        'mfg_upc',
        'last_update',
        array(
            'header' => 'VIMS<br/>Supp<br/>ID1',
            'name' => 'sup_id',
        ),
        array(
            'name' => 'id',
            'header' => 'VIMS<br/>Supp<br/>ID2',
        ),
        array(
            'name' => 'supplier.ubs_supplier_id',
            'header' => 'UBS<br/>Supp<br/>ID',
            'value' => '$data->supplier->ubs_supplier_id',
        ),
        array(
            'header' => 'Read<br/>Edit<br/>Delete',
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/supInventory/supupdate", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
));
?>
<script>
    $(document).on('change', ".editdropdown", function(){
        $.ajax({
            url: "/index.php/supInventory/ajaxSupstatus",
            data:{
                'id': $(this).attr(':id'),
                'value': $(this).val()
            },
            error:function (xhr, ajaxOptions, thrownError){


                alert('not saving, maybe supplier inactive');
            }

        });
        console.log("change");
    });
</script>
<div id="data">
</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-import')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Import seed sheet</h4>
</div>

<div class="modal-body">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'frm-import',
        'type' => 'horizontal',
        'action' => $this->createUrl('import', array('id' => $tabId)),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
    ?>
    <fieldset>
        <?php echo $form->fileFieldRow($model, 'importFile'); ?>
    </fieldset>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Submit')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Reset')); ?>
    <?php $this->endWidget(); ?>
</div>
<?php $this->endWidget(); ?>