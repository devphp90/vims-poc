<?php
$this->breadcrumbs=array(
	'Import Warnitem Qty'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array(
		'label'=>'Search', 
		'url'=>'#',
		'linkOptions'=>array(
			'class'=>'search-button',
		),
	),
	array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-warnitem-qty-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>

	
	<div class="modal-body">
		Item Status = Status of Item as of last Update<br/>
		Action Taken:  User picks (I)nStock, (B)ack Order, or (D)iscontinue for each Item.
	</div>
 
	<div class="modal-footer">
	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>
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
<h1>Supplier Items, Qty Warnings</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'import-warnitem-qty-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'importRoutine.supplier.name', 
			'type' => 'raw', 
			'header' => 'Supplier Name', 
			'filter' => CHtml::activeTextField($model, 'supplier_name'),
			'value' => 'CHtml::link($data->importRoutine->supplier->name, Yii::app()->controller->createUrl("tabs/update", array("id" => $data->importRoutine->supplier->tabs->id)))'
		),
		'sup_vsku',
		
		'mfg_sku',
		'mfg_name',
		'mfg_part_name',
		/*
		array(
			'header'=>'Item Status',
			'value'=>'"InStock"',
		),
		/*
		/*array(

			'header'=>'Action<br/>Taken',
			'type'=>'raw',
			'value'=>'CHtml::radioButtonList("action_".$data->id,0, array(1=>"I",0=>"B",2=>"D"),array(":id"=>$data->id,"labelOptions"=>array("style"=>"display:inline;",),"separator"=>" ","template"=>"{label}{input}"))',
			'htmlOptions'=>array(
				'style'=>'width:100px;',
			),

		),*/
		array(
			'header'=>'VIMS<br/>Stock Status',
			//'name'=>'sup_status',
			'type'=>'raw',
			'value'=>'CHtml::dropdownlist("sup_status",$data->suppItem->sup_status,array(1=>"InStock", 0=>"BackOrdered", 3=>"Missing", 2=>"Discontinued"),array("class"=>"span2 editdropdown","data-id"=>$data->suppItem->id))',
		),
		array(
			'header'=>'QTY Current Update',
			'name'=>'qty',
		),
		array(
			'header'=>'QTY Previous Update',
			'name'=>'lastqty',
		),
		array(
			'header'=>'% Difference',
			'value'=>'$data->lastqty?(($data->qty-$data->lastqty)/$data->lastqty)*100:"N/A"',
		),
		'import_id',
		'id',
		
		
		
		
		/*
		'map',
		'ware_1',
		'ware_2',
		'ware_3',
		'ware_4',
		'ware_5',
		'ware_6',
		'qty',
		'lastqty',
		'mfg_sku',
		'mfg_name',
		'mfg_part_name',
		'upc',
		'sup_sku_name',
		*/
	),
)); ?>
<script>
	$(document).on('change', ".editdropdown", function(){
		$.ajax({
			url: "/index.php/supInventory/ajaxSupstatus",
			data:{
				'id': $(this).attr('data-id'),
				'value': $(this).val()
			},
			error:function (xhr, ajaxOptions, thrownError){


				alert('not saving, maybe supplier inactive');
			}

		});
		console.log("change");
	});
</script>