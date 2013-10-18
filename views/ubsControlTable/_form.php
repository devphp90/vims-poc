<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ubs-control-table-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'TableId',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'TableName',array('class'=>'span5','maxlength'=>60)); ?>

	<?php echo $form->textFieldRow($model,'Status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'DateLastUpdate',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
