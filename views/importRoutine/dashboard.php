<?php

$this->breadcrumbs=array(
	'Import Routines'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'Start All Routine', 'url'=>'start?option=all','linkOptions'=>array('target'=>'_blank')),
	
	array('label'=>'Create', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-routine4-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Supplier Import Routines</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'import-routine4-grid',
	'ajaxUpdate' =>false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'sup_name',
			'type'=>'raw',
			'value'=>'CHtml::link($data->supplier->name,array(\'/Supplier/view\',\'id\'=>$data->sup_id),array(\'target\'=>\'_blank\')).\'<br/>\'.$data->sup_id',

		),
		
		array(
			'header'=>'Sheet Name<br/>Click to download latest version.',
			'name'=>'file_name',
			'type'=>'raw',
			'value'=>'!empty($data->import->import_file_url)?(\'<a target="_blank" href="\'.$data->import->import_file_url.\'">\'.$data->file_name.\'</a>\'):$data->file_name',
		),
		
		
		
		
		array(
			'header'=>'Manual Update',
			'type'=>'raw',
			'value'=>'\'<a target="_blank" href="manual?id=\'.$data->id.\'">Upload File</a>\'',
		),
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
