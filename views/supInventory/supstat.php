<?php
$this->breadcrumbs=array(
	'Supplier Inventory'=>array('index'),
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
	$.fn.yiiGridView.update('ubs-inventory4-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Supplier Items Cancel Rate Limit</h1>



<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'ubs-inventory4-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText'=>'',
	'columns'=>array(
		
		'sup_vsku',
		'cancel_rate_limit',
		'id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<div id="data">
</div>
