<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ubs-supplier-item-seed-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'SupplierName',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'SupplierID',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'SKU',array('class'=>'span5','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'MPN',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'upc',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'SupplierSKU',array('class'=>'span5','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'ItemName',array('class'=>'span5','maxlength'=>500)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
