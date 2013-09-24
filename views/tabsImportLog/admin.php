<?php
$this->breadcrumbs=array(
	'Import Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TabsImportLog','url'=>array('index')),
	array('label'=>'Create TabsImportLog','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tabs-import-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Import Logs</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tabs-import-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'header'=>'Tab Id',
			'name'=>'tab.id',
		),
		array(
			'header'=>'Prepared Sheet 1',
			'name'=>'download_sheet1_status',
			'type'=>'raw',
			'value'=>'$data->_status[$data->download_sheet1_status]."<br/>".$data->download_sheet1_reason',
		),
		array(
			'header'=>'Prepared Sheet 2',
			'name'=>'download_sheet2_status',
			'type'=>'raw',
			'value'=>'$data->_status[$data->download_sheet2_status]."<br/>".$data->download_sheet2_reason',
		),
		'data_integrity_status',
		'data_integrity_reason',
		'overall_item_status',
		'overall_item_reason',
		'create_time',
		'finish_time',
		'status',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
