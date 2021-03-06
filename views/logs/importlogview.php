<?php
/* @var $this LogsController */
/* @var $model Logs */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Clear Log(supplier)', 'url'=>array('deleteAllSupplier','id'=>$id)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('logs-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Logs</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'logs-grid',
	'dataProvider'=>$model->searchSupplier($id),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'id',
			'htmlOptions'=>array(
				'style'=>'width:40px;',
			),
		),
		array(
			'name'=>'import_id',
			'htmlOptions'=>array(
				'style'=>'width:40px;',
			),
		),
		array(
			'header'=>'Supplier Name<br/>Supplier ID',
			'type'=>'raw',
			'name'=>'sup_name',
			'value'=>'$data->supplier->name."<br/>".$data->supplier->id',
			'value'=>'CHtml::link($data->supplier->name,array(\'/Supplier/view\',\'id\'=>$data->supplier->id),array(\'target\'=>\'_blank\')).\'<br/>\'.$data->supplier->id',
			'htmlOptions'=>array(
				'style'=>'width:100px;',
			),
		),
		array(
			'name'=>'create_time',
			'htmlOptions'=>array(
				'style'=>'width:75px;',
			),
		),
		array(
			'name'=>'import_status',
			'type'=>'raw',
			'value'=>'$data->_status[$data->import_status]."<br/>".$data->import_reason',
		),
		array(
			'name'=>'data_integrity_status',
			'type'=>'raw',
			'value'=>'$data->_status[$data->data_integrity_status]."<br/>".$data->data_integrity_reason',
			
		),
		array(
			'name'=>'overall_item_status',
			'type'=>'raw',
			'value'=>'$data->_status[$data->overall_item_status]."<br/>".$data->overall_item_reason',
			
		),
		array(
			'name'=>'prepare_status',
			'type'=>'raw',
			'value'=>'$data->_status[$data->prepare_status]."<br/>".$data->prepare_reason',
			
		),

		array(
			'name'=>'item_number',
			'htmlOptions'=>array(
				'style'=>'width:45px;',
			),
		),

		array(
			'name'=>'update_time',
			'htmlOptions'=>array(
				'style'=>'width:75px;',
			),
		),
		array(
			'name'=>'file_size',
			'htmlOptions'=>array(
				'style'=>'width:80px;',
			),
		),
		'status',
	),
)); 

?>
<div id="data">
</div>
