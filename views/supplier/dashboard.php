<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Export pdf','url'=>array('pdf'),),
	array('label'=>'Export excel','url'=>array('excel')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('supplier-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Suppliers</h1>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'supplier-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array('name' => 'setup_status', 'value' => '$data->setupStatusValues[$data->setup_status]'),
		array(
			'header'=>'Active/InActive',
			'type'=>'raw',
			'value'=>'CHtml::ajaxLink($data->active==1?"Active":"InActive",Yii::app()->controller->createUrl("/supplier/ajaxStatus",array("id"=>$data->id)),array(
				"success"=>\'function(res){$("#status_\'.$data->id.\'").html(res)}\',
			
			),array(
				"id"=>"status_".$data->id,
			
			));',
		),
	),
)); ?>
