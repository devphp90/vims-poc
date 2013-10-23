<?php
$this->breadcrumbs=array(
	'Import Vsheets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
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

<h1>vSheet: <?php echo $supName?></h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'import-vsheet-grid',
	'dataProvider'=>$model->supsearch($id),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'columns'=>array(
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
			'name' => 'mfg_name',
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),
		),
		array(
			'header'=>'Mfg<br/>Part<br/>Name',
			'name'=>'mfg_part_name',
		),

		'price',
		'map',
		array(
			'header'=>'is From sheet 2?',
			'value'=>'$data->sheet_type?"y":"n"',
		),


		'ware_1',
		'ware_2',
		'ware_3',
		'ware_4',
		'ware_5',
		'ware_6',


		'upc',
		'sup_sku_name',

		array(
			'header'=>'VIMS<br/>ID',
			'name'=>'id',
			'type'=>'raw',
		),
		array(
			'header'=>'Import<br/>ID',
			'name'=>'import_id',
			'type'=>'raw',
		),
		array(
			'header'=>'Supplier',
			'type'=>'raw',
			'name'=>'sup_id',
			'value'=>'CHtml::link($data->importRoutine->supplier->name,array("/supplier/".$data->importRoutine->supplier->id)).\'<br/>\'.$data->importRoutine->supplier->id',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
