<?php
/* @var $this SystemInfoController */
/* @var $model SystemInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-info-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cancel_rate_limit'); ?>
		<?php echo $form->textField($model,'cancel_rate_limit'); ?>
		<?php echo $form->error($model,'cancel_rate_limit'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'global_cancel_rate_limit'); ?>
		<?php echo $form->textField($model,'global_cancel_rate_limit'); ?>
		<?php echo $form->error($model,'global_cancel_rate_limit'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'percent_change'); ?>
		<?php echo $form->textField($model,'percent_change'); ?>
		<?php echo $form->error($model,'percent_change'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'primary_email'); ?>
		<?php echo $form->textField($model,'primary_email'); ?>
		<?php echo $form->error($model,'primary_email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'secondary_email'); ?>
		<?php echo $form->textField($model,'secondary_email'); ?>
		<?php echo $form->error($model,'secondary_email'); ?>
	</div>
-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->