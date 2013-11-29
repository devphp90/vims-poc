<?php
$this->breadcrumbs=array(
	'Ubs Supplier Seeds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ','url'=>array('index')),
	array('label'=>'Create ','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-supplier-seed-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Supplier Seeds</h1>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-supplier-seed-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'SupplierID',
		'SupplierName',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
