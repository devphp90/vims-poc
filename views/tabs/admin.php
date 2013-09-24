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





<h1>Suppliers</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->renderPartial('_suppliers', array('model' => $model, 'supplierOnly' => $supplierOnly)); ?>

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