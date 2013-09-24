<?php
/** @var TbActiveForm $form  */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ubs-supplier-stat-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'SupplierId',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'SupplierName',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'OrderCount',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'OrderCount_Last30Days',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'Shipdays_OrderCount',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ShipDays',array('class'=>'span5','maxlength'=>38)); ?>

	<?php echo $form->textFieldRow($model,'ShipDays_AllUnder30',array('class'=>'span5','maxlength'=>38)); ?>

	<?php echo $form->textFieldRow($model,'BusinessShipDays',array('class'=>'span5','maxlength'=>38)); ?>

	<?php echo $form->textFieldRow($model,'BusinessShipDays_allunder30',array('class'=>'span5','maxlength'=>38)); ?>

	<?php echo $form->textFieldRow($model,'ShipDays_Last30Days',array('class'=>'span5','maxlength'=>38)); ?>

	<?php echo $form->textFieldRow($model,'CancelOrderCount',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'CancelRate',array('class'=>'span5','maxlength'=>37)); ?>

	<?php echo $form->textFieldRow($model,'CancelRate_Last30Days',array('class'=>'span5','maxlength'=>37)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
