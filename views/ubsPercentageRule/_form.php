<?php
/* @var $this UbsPercentageRuleController */
/* @var $model UbsPercentageRule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ubs-percentage-rule-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'start_price'); ?>
		<?php echo $form->textField($model,'start_price'); ?>
		<?php echo $form->error($model,'start_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_price'); ?>
		<?php echo $form->textField($model,'end_price'); ?>
		<?php echo $form->error($model,'end_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'percent'); ?>
		<?php echo $form->textField($model,'percent'); ?>%
		<?php echo $form->error($model,'percent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->