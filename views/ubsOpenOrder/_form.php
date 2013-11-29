<?php
/** @var TbActiveForm $form  */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ubs-open-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'ItemNumber',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'Product',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'QuantityOrdered',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'OrderNumber',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->datepickerRow($model,'OrderDate',array('class'=>'span5', 'options' => array('format'=>'yyyy-mm-dd'))); ?>

	<?php echo $form->textFieldRow($model,'Name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'SupplierName',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'Phone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Email',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'SKU',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'SupplierID',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'CartID',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
