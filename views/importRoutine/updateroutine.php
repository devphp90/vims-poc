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

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'import-routine4-grid',
	'filter'=>$model,
	'ajaxUpdate' =>false,
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		array(
			'name'=>'sup_name',
			'type'=>'raw',
			'value'=>'CHtml::link($data->supplier->name."(".(!$data->supplier->active?"Inactive":"Active").")",array(\'/Supplier/view\',\'id\'=>$data->sup_id),array(\'target\'=>\'_blank\')).\'<br/>\'.$data->sup_id',

		),
		array(
			'header'=>'Retrieval Method',
			'name'=>'import_method.type',
			'htmlOptions'=>array(
				'width'=>'40',
			),
		),

		array(
			'header'=>'Server',
			'name'=>'import_server.name',
			'type'=>'raw',
			'value'=>'CHtml::link($data->import_server->name,array(\'/ImportRoutineServer/view\',\'id\'=>$data->server_id),array(\'target\'=>\'_blank\'))',
		),
		
		array(
			'header'=>'Sheet Name<br/>Click to download latest version.',
			'name'=>'file_name',
			'type'=>'raw',
			'value'=>'!empty($data->import->import_file_url)?(\'<a target="_blank" href="\'.$data->import->import_file_url.\'">\'.$data->file_name.\'</a>\'):$data->file_name',
		),
		array(
			'name'=>'frequency',
			'value'=>'$data->frequency."  ".($data->frequency_option == 1?\'Day\':$data->frequency_option == 2?\'Minutes\':\'Hour\')',
		),
		array(
			'header'=>'Run Auto Update <font color="green">*</font>',
			'type'=>'raw',
			'htmlOptions'=>array(
				'width'=>'60',
			),
			'value'=>'CHtml::ajaxLink($data->status==1?"Yes":"No",Yii::app()->controller->createUrl("/ImportRoutine/ajaxStatus",array("id"=>$data->id)),array(
				"success"=>\'function(res){$("#status_\'.$data->id.\'").html(res)}\',
			
			),array(
				"id"=>"status_".$data->id,
			
			));',
		),
/*
		array(
			'header'=>'Manual Update',
			'type'=>'raw',
			'value'=>'\'<a target="_blank" href="manual?id=\'.$data->id.\'">Upload File</a>\'',
		),
*/
		array(
			'header'=>'Run Update Now',
			'type'=>'raw',
			'value'=>'\'<a target="_blank" href="updateFile?id=\'.$data->id.\'">Update Now</a>\'',
		),
		array(
			'header'=>'View Update Log',
			'type'=>'raw',
			'value'=>'CHtml::link(\'Update Log\',array(\'/logs/updatelogview\',\'id\'=>$data->id),array())',
		),
		'import.last_import_time',
		'update.last_update_time',
		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}{delete}',
		),
	),
)); ?>
