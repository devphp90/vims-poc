<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tabs-main-log-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'tabs_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet1_file_size',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet2_file_size',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet1_row',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet2_row',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
