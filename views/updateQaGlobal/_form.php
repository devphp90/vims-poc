<?php
/* @var $this UpdateQaGlobalController */
/* @var $model UpdateQaGlobal */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'update-qa-global-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'item_percent'); ?>
		<?php echo $form->textField($model,'item_percent'); ?>
		<?php echo $form->error($model,'item_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instock_percent'); ?>
		<?php echo $form->textField($model,'instock_percent'); ?>
		<?php echo $form->error($model,'instock_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qoh_percent'); ?>
		<?php echo $form->textField($model,'qoh_percent'); ?>
		<?php echo $form->error($model,'qoh_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_percent'); ?>
		<?php echo $form->textField($model,'price_percent'); ?>
		<?php echo $form->error($model,'price_percent'); ?>
	</div>


	<div class="row buttons">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->