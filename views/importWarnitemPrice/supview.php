<?php
$this->breadcrumbs=array(
	'Import Warnitem Prices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	array('label'=>'Create','url'=>array('create')),
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

<h1>Warn Prices Item: <?php echo $supName?> </h1>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'import-warnitem-price-grid',
	'dataProvider'=>$model->supsearch($id),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'columns'=>array(
		'id',
		'sup_vsku',
		'mfg_sku',
		'mfg_name',
		'mfg_part_name',

		'price',
		'last_price',
		'import_id',
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
