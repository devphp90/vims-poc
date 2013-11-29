<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ubs-product-status-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'dtCreated',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'Action',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'Completed',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'SKU',array('class'=>'span5','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'StockStatusID',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
