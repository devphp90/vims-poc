<?php
$this->breadcrumbs=array(
	'Email Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EmailSuppliers','url'=>array('index')),
	array('label'=>'Create EmailSuppliers','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('email-suppliers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Email Suppliers</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'email-suppliers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
            'name' => 'supplier_id',
            'value' => '$data->supplier->name'
        ),

		'content',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
