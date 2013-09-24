<?php
$this->breadcrumbs=array(
	'Sup Warehouses'=>array('index'),
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
	$.fn.yiiGridView.update('sup-warehouse-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sup Warehouses</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sup-warehouse-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sup_id',
		'supplier.name',
		'name',
		'state',
		'zip_code',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
