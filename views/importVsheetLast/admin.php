<?php
$this->breadcrumbs=array(
	'Import Vsheet Lasts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ImportVsheetLast','url'=>array('index')),
	array('label'=>'Create ImportVsheetLast','url'=>array('create')),
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-vsheet-last-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Import Vsheet Lasts</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'import-vsheet-last-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'import_id',
		'sheet_type',
		'update_type',
		'sup_vsku',
		'price',
		/*
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
		'sup_sku_name',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
