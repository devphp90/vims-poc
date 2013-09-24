<?php
/* @var $this LogsController */
/* @var $model Logs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'logs-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'import_id'); ?>
		<?php echo $form->textField($model,'import_id'); ?>
		<?php echo $form->error($model,'import_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_size'); ?>
		<?php echo $form->textField($model,'file_size'); ?>
		<?php echo $form->error($model,'file_size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_number'); ?>
		<?php echo $form->textField($model,'item_number'); ?>
		<?php echo $form->error($model,'item_number'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->