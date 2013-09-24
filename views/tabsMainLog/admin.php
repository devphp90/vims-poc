<?php
$this->breadcrumbs=array(
	'Tabs Main Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TabsMainLog','url'=>array('index')),
	array('label'=>'Create TabsMainLog','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tabs-main-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tabs Main Logs</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tabs-main-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'tabs_id',
		'sheet1_file_size',
		'sheet2_file_size',
		'sheet1_row',
		'sheet2_row',
		'create_time',
		'status',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
