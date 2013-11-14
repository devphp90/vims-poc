<?php
$this->breadcrumbs=array(
	'Supplier Setup'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	//array('label'=>'Create','url'=>array('create')),
	array(
		'label'=>'Search', 
		'url'=>'#',
		'linkOptions'=>array(
			'class'=>'search-button',
		),
	),
	array(
		'label'=>'Create',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
);
/*
$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Click me',
	'type'=>'primary',
	'htmlOptions'=>array(
		'data-toggle'=>'modal',
		'data-target'=>'#myModal',
	),
));
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tabs-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php 

$newTab = new Tabs;
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Create</h4>
    </div>
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'tabs-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'action'=>'create',
	)); ?>

	
	<div class="modal-body">
		<?php echo $form->errorSummary($newTab); ?>
	    <?php echo $form->textFieldRow($newTab,'supplier_name',array('class'=>'span2')); ?>
	</div>
 
	<div class="modal-footer">
	
	
		<?php  
			$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit', 
				'type'=>'primary',
				'label'=>$newTab->isNewRecord ? 'Create' : 'Save',
				'htmlOptions'=>array(
				),
			)); 
		?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>
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
<h1>Suppliers</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tabs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUpdate'=>false,
	'columns'=>array(
		
		array(
			'type'=>'raw',
			'name'=>'supplier_name',
			'value'=>'CHtml::link($data->supplier->name,array("update","id"=>$data->id))',
		),
		array(
			'header'=>'Supplier Items',
			'type'=>'raw',
			'value'=>'CHtml::link(\'Supp Items\',array(\'/supInventory/supview\',\'id\'=>$data->id),array())',
		),
		array(
			'header'=>'Active<br/>Inactive',
			'name'=>'supplier.active',
			'type'=>'raw',
			'value'=>'CHtml::ajaxLink($data->supplier->active?"Active":"Inactive",Yii::app()->controller->createUrl("/supplier/statusToggle",array("id"=>$data->supplier_id)),array(
				"success"=>\'function(res){$(".status_\'.$data->supplier_id.\'").html(res)}\',
			
			),array(
				"class"=>"status_".$data->supplier_id,
			
			));',
		),

		
		'create_time',
		
		
		array(
			'header'=>'VIMS Supp ID1',
			'name'=>'supplier_id',
		),
		array(
			'header'=>'VIMS Supp ID2',
			'name'=>'id',
		),
		array(
			'header'=>'UBS Supp ID',
			'name'=>'supplier.ubs_supplier_id',
		),
		
		
		//'id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
