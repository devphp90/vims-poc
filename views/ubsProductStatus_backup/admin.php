<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label' => ''),
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-product-status-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Product Statuses</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-product-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'SKU',
		'StockStatusID',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
