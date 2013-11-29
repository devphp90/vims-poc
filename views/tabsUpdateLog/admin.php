<?php
$this->breadcrumbs=array(
	'Tabs Update Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TabsUpdateLog','url'=>array('index')),
	array('label'=>'Create TabsUpdateLog','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tabs-update-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tabs Update Logs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tabs-update-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'tabs_id',
		'data_integrity_status',
		'data_integrity_reason',
		'qoh_item_percent_change_status',
		'qoh_item_percent_change_reason',
		/*
		'price_item_percent_change_status',
		'price_item_percent_change_reason',
		'instock_item_status',
		'instock_item_reason',
		'qoh_percent_change_status',
		'qoh_percent_change_reason',
		'price_percent_change_status',
		'price_percent_change_reason',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
