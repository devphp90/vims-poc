<?php
/* @var $this WizardsController */
/* @var $model Wizards */

$this->breadcrumbs=array(
	'Sup Setup'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('wizards-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Supplier Setups</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'wizards-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sup_name',
		'create_time',
		'create_by',
		array(
			'header'=>'Status',
			'value'=>'$data->status?\'Complete\':\'In Progress\'',
		),
		array(
			'type'=>'raw',
			'value'=>'CHtml::link(\'Continue\',array(\'/wizards/wizard\',\'id\'=>$data->id))',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
