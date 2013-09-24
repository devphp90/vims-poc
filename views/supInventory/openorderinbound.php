<?php
$this->breadcrumbs=array(
	'Supplier Inventory'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Advanced Search','url'=>'#','linkOptions'=>array('class'=>'search-button')),
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

<h1>Supplier Items Open Orders</h1>



<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'ubs-inventory4-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText'=>'',
	'columns'=>array(
		'supplier.id',
		'supplier.name',

		array(
			'name'=>'sup_open_order',
		),

		
		array(
			'header'=>'Read<br/>Edit<br/>Delete',
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<div id="data">
</div>
