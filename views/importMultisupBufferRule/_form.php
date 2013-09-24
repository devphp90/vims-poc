<?php
/* @var $this ImportMultisupBufferRuleController */
/* @var $model ImportMultisupBufferRule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-multisup-buffer-rule-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sup_qty'); ?>
		<?php echo $form->textField($model,'sup_qty'); ?>
		<?php echo $form->error($model,'sup_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_qty'); ?>
		<?php echo $form->textField($model,'start_qty'); ?>
		<?php echo $form->error($model,'start_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_qty'); ?>
		<?php echo $form->textField($model,'end_qty'); ?>
		<?php echo $form->error($model,'end_qty'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from'); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->