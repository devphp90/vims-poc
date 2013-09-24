<?php
/* @var $this ImportRoutineServerController */
/* @var $model ImportRoutineServer */

$this->breadcrumbs=array(
	'Import Routine Servers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-routine-server-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Import Routine Servers</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'import-routine-server-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'domain',
		'update_url',
		array(
			'name'=>'status',
			'value'=>'$data->status?\'Active\':\'InActive\'',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
