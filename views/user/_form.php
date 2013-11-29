<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


		<?php echo $form->textFieldRow($model,'username',array('size'=>50,'maxlength'=>50)); ?>
<?php if($model->isNewRecord) {?>
		<?php echo $form->passwordFieldRow($model,'password',array('size'=>50,'maxlength'=>50)); ?>
<?php } else {?>
		<?php echo $form->passwordFieldRow($model,'newPassword',array('size'=>50,'maxlength'=>50,'hint' => 'If you don\'t need to change password, leave it blank.', 'autocomplete' => 'off')); ?>
<?php } ?>
		<?php echo $form->textFieldRow($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'email',array('size'=>60,'maxlength'=>100)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->