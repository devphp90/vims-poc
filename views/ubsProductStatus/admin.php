<?php
$this->breadcrumbs=array(
	'Ubs Product Statuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
	array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
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
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>

	
	<div class="modal-body">
		
	</div>
 
	<div class="modal-footer">
	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>
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
<h1>Manage Ubs Product Statuses</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
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
		'id',
		'dtCreated',
		'Action',
		'Completed',
		'SKU',
		'StockStatusID',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
