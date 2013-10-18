<style>
.grid-view .summary {
    float: right;
    margin-bottom: 5px;
    position: absolute;
    right: 62px;
    text-align: right;
    top: 152px;
    width: 249px;
}
</style>
<?php
$this->breadcrumbs=array(
	'Ubs Control Tables'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	array('label'=>'Create','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-control-table-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Control Tables</h1>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-control-table-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'TableId',
		'TableName',
		'Status',
		'DateLastUpdate',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
