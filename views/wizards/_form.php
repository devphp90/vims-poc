<?php
/* @var $this WizardsController */
/* @var $model Wizards */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wizards-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'sup_name'); ?>
		<?php echo $form->textField($model,'sup_name',array('size'=>32,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sup_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status',array('label'=>'Status')); ?>
		<?php echo $form->dropDownList($model,'status',array('In progress','Complete')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->