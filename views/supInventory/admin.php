<?php
$this->breadcrumbs=array(
	'Supplier Inventory'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
	array('label'=>'Total:'.$total,'url'=>'#'),
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
<h1>Manage Supplier Inventory Items</h1>



<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'ubs-inventory4-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'summaryText'=>'',
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
	'columns'=>array(
		'sup_vsku',
		array(
			'name'=>'ubs_sku',
			'type'=>'raw',
			'value'=>'CHtml::link($data->ubs_sku,array("/ubsInventory/admin?UbsInventory%5Bsku%5D=".$data->ubs_sku))',
		),

		array(
			'name'=>'mfg_name',
		),
		array(
			'name'=>'mfg_sku_name',
		),
		array(
			'header'=>'Item Status',
			'value'=>'$data->item_status?"Active":"Inactive"',
		),
		'uprice',
		'umap',
		'uqty',
		
		
		'sup_price',
		'sup_min_adv_price',
		array(
			'header'=>'Stock Status',
			'name'=>'sup_status',
			'type'=>'raw',
			//'value'=>'$data->sup_status?$data->sup_status==1?\'INSTOCK\':\'BO\':\'DISCO\'',
			'value'=>'CHtml::dropdownlist("sup_status",$data->sup_status,array("BO","INSTOCK","DISCO"),array("class"=>"span2 editdropdown",":id"=>$data->id))',
		),
		array(
            'class'=>'bootstrap.widgets.TbRelationalColumn',
            'header'=>'sQOH<br/>Warehouse detail',

			'url' => $this->createUrl('/supWarehouseItem/ajaxItem'),
            'value'=> '$data->qty_total_c',
            'filter'=>false,
			'sortable'=>false,
		),
		'ibuffer_c',
		'sbuffer_c',
		'gbuffer_c',
		array(
			'header'=>'Apply Buffer',
			'value'=>'$data->buffer_c',
		),
		array(
			'name'=>'sup_bqoh_c',

		),
		array(
			'name'=>'sup_open_order',
		),
		array(
			'name'=>'sup_vqoh_c',

		),
		

		'sup_sku',
		'mfg_sku',
		'mfg_upc',
		'last_update',
		array(
			'header'=>'Supp ID',
			'name'=>'sup_id',
		),
		array(
			'header'=>'ID',
			'name'=>'id',
		),
		array(
			'header'=>'Read<br/>Edit<br/>Delete',
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<div id="data">
</div>
