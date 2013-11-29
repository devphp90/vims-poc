<?php
$this->breadcrumbs=array(
	'Ubs Vims Ubs Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label' => ''),
	//array('label'=>'List UbsVimsUbsProduct','url'=>array('index')),
	//array('label'=>'Create UbsVimsUbsProduct','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-vims-ubs-product-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>UBS Products, VIMS-to-UBS</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-vims-ubs-product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'ubs_sku',
		'primary_supplier_ubs_id',
		'primary_supplier_vims_id',
		'primary_supplier_vsheet_mpn',
		'primary_supplier_vsheet_upc',
		
		'primary_supplier_vsheet_manufacturer',
		'primary_supplier_vsheet_item_description',
		'primary_supplier_vsheet_price',
		'primary_supplier_vsheet_map_price',
		'primary_supplier_vsheet_our_cost',
		'primary_supplier_vsheet_qoh',
		'primary_supplier_vsheet_sku',
		'sale_price',
		'sale_qoh',
		'dtCreated',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
