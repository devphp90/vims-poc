<?php
$this->breadcrumbs=array(
	'Import Routine'=>array('index'),
	'Manual Update',
);
$this->helpText = 'help here';
$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Manage', 'url'=>array('admin')),

);
?>

<h1>Ubs Item Import</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'manual-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->fileField($model,'file'); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'start_at'); ?>
		<?php echo $form->textField($model,'start_at'); ?>
		<?php echo $form->error($model,'start_at'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sku'); ?>
		<?php echo $form->textField($model,'sku'); ?>
		<font color="red">*</font><font color="green">*</font>
		<?php echo $form->error($model,'sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sku_name'); ?>
		<?php echo $form->textField($model,'sku_name'); ?>
		<?php echo $form->error($model,'sku_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'vprice'); ?>
		<?php echo $form->textField($model,'vprice'); ?>
		<?php echo $form->error($model,'vprice'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sku_description'); ?>
		<?php echo $form->textArea($model,'sku_description'); ?>
		<?php echo $form->error($model,'sku_description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_title'); ?>
		<?php echo $form->textField($model,'mfg_title'); ?>
		<?php echo $form->error($model,'mfg_title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_name'); ?>
		<?php echo $form->textField($model,'mfg_name'); ?>
		<?php echo $form->error($model,'mfg_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mfg_part_name'); ?>
		<?php echo $form->textField($model,'mfg_part_name'); ?>
		<?php echo $form->error($model,'mfg_part_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'upc'); ?>
		<?php echo $form->textField($model,'upc'); ?>
		<?php echo $form->error($model,'upc'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Import'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->