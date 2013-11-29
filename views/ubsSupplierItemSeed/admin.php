<?php
$this->breadcrumbs=array(
	'Ubs Supplier Item Seeds'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'')
	//array('label'=>'List ','url'=>array('index')),
	//array('label'=>'Create ','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-supplier-item-seed-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
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
<h1>UBS-VIMS Supplier Items Seed</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-supplier-item-seed-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'SupplierName',
		'SupplierID',
		'SKU',
		'MPN',
		'upc',
		
		'SupplierSKU',
		'ItemName',
		
		//array(
		//	'class'=>'bootstrap.widgets.TbButtonColumn',
		//),
	),
)); ?>
