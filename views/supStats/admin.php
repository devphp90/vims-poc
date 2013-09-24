<?php
$this->breadcrumbs=array(
	'Sup Stats'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sup-stats-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sup Stats</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sup-stats-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'sup_id',
			'type'=>'raw',
			'value'=>'$data->supplier->id.\'<br/>\'.$data->supplier->name',
		),
		'cancel_rate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
