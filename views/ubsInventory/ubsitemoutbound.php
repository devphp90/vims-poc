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

<h1>UBS Items</h1>

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
    'summaryText'=>'',
    'columns' => 
    array(
		array(
			'name'=>'sku',
			'sortable'=>false,
		),
		array(
			'header'=>'Sell Price',
			'name'=>'mark_up_sale_price',
			'value'=>'$data->markup_c+$data->vprice',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		array(
			'header'=>'Effective mQTY',
			'name'=>'vqoh',
			'value'=>'$data->mqoh_c',
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

?>
<div id="data"></div>
