<?php
$this->breadcrumbs=array(
	'Import Warnitem Prices'=>array('index'),
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
	array(
		'label'=>'Accept Page',
		'url'=>'#',
	),
	array(
		'label'=>'Accept All',
		'url'=>'#',
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-warnitem-price-grid', {
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
<h1>Supplier Update, Price Item Warnings</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'import-warnitem-price-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'importRoutine.supplier.name',
		'sup_vsku',
		'mfg_sku',
		'mfg_name',
		'mfg_part_name',
		/*array(
			'header'=>'Item Status',
			'value'=>'"InStock"',
		),*/
		
		array(
			'header'=>'User Item Status',
			'type' => 'raw',
			'value'=>'CHtml::link($data->suppItem->item_status?"Active":"Inactive", "#", array("class" =>"status", "data-id" => $data->suppItem->id))',
			
		),
		
		/*array(

			'header'=>'Action<br/>Taken',
			'type'=>'raw',
			'value'=>'CHtml::radioButtonList("action_".$data->id,0, array(1=>"I",0=>"B",2=>"D"),array(":id"=>$data->id,"labelOptions"=>array("style"=>"display:inline;",),"separator"=>" ","template"=>"{label}{input}"))',
			'htmlOptions'=>array(
				'style'=>'width:100px;',
			),

		),*/
		array(
			'header'=>'Price Current Update',
			'name'=>'price',
		),
		array(
			'header'=>'Price Previous Update',
			'name'=>'last_price',
		),
		array(
			'header'=>'% Difference',
			'value'=>'$data->last_price?(($data->price-$data->last_price)/$data->last_price)*100:"N/A"',
		),

		array(
			'header'=>'VIMS Supp ID1',
			'name'=>'importRoutine.sup_id',
		),
		array(
			'header'=>'VIMS Supp ID2',
			'name'=>'tabs.id',
		),
		array(
			'header'=>'UBS Supp ID',
			'name'=>'importRoutine.supplier.ubs_supplier_id',
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
		
		'upc',
		'sup_sku_name',
		*/
	),
)); ?>
<script>
$('a.status').live('click', function () {
		id = $(this).attr('data-id');
		$(this).text('Loading...');
		elemen = $(this);
		$.ajax({
				url: '<?php echo $this->createUrl('/supInventory/changeStatus') ?>',
			type: 'POST',
			data: {id: id},
			success: function (response) {
				if(response == 0) {
					elemen.text("Inactive");
				} else {
					elemen.text("Active");
				}
			}
		
		});
		return false;
	});
</script>