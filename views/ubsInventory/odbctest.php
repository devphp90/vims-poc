<?php
$this->breadcrumbs=array(
	'Ubs Inventory'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Import', 'url'=>array('manual')),
	array(
		'label'=>'Search', 
		'url'=>'#',
		'linkOptions'=>array(
			'class'=>'search-button',
		),
	),
	array(
		'label'=>'Record Count = '.$count,
		'url'=>'#',
	),
	array(
		'label'=>'Write to VIMs-Front',
		'url'=>'writeFront',
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-inventory-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>InBound ODBC Test</h1>

<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
//	'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'ubs-inventory-grid',
    'filter'=>$model,

    'type'=>'striped',
    'dataProvider' => $model->search(),
    'columns' => 
    array(
		array(
			'name'=>'ProductID',
			'sortable'=>false,
		),
		array(
			'name'=>'Sku',
			'sortable'=>false,
		),
		array(
			'name'=>'Name',
			'sortable'=>false,
		),
		array(
			'name'=>'SalePrice',
			'sortable'=>false,
		),
		array(
			'name'=>'Manufacturer',
			'sortable'=>false,
		),
		array(
			'name'=>'MPN',
			'sortable'=>false,
		),
		array(
			'name'=>'UPC',
			'sortable'=>false,
		),
		array(
			'name'=>'OurCost',
			'sortable'=>false,
		),
		array(
			'name'=>'QTY',
			'sortable'=>false,
		),
		array(
			'name'=>'PRICE',
			'sortable'=>false,
		),
		
		
    ),
    

));


/*
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'ubs-inventory-grid',
    'filter'=>$model,

    'type'=>'striped',
    'dataProvider' => $model->search(),
    'summaryText'=>'',
    'columns' => 
    array(
		array(
			'name'=>'sku',
			'sortable'=>false,
		),
		array(
			'header'=>'Sale Price',
			'name'=>'mark_up_sale_price',
			'value'=>'$data->getMarkupPrice()',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		array(
			'header'=>'Effective mQOH',
			'name'=>'vqoh',
			'value'=>'$data->getmQOH()',
			'filter'=>false,
			'sortable'=>false,
		),

		
		
		array(
			'header'=>'ID',
			'name'=>'id',
			'sortable'=>false,
			'htmlOptions'=>array(
				'style'=>'width: 100px;',
			),
		),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array(
				'style'=>'width: 100px;',
			),
		),
		
		
    ),
    

));
*/
?>
<div id="data"></div>
