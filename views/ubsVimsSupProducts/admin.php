<?php
$this->breadcrumbs=array(
	'Ubs Vims Sup Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'','url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-vims-sup-products-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Vims Sup Products</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-vims-sup-products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'action',
		'ubs_sku',
		'supplier_ubs_id',
		'supplier_name',
		'mpn',
		
		'upc',
		'supplier_sku',
		'ubs_manufacturer',
		'item_description',
		'our_cost',
		'qoh',
		'dtCreated',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
