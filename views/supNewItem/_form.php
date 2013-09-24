<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sup-new-item4-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'import_id'); ?>
		<?php echo $form->textField($model,'import_id'); ?>
		<?php echo $form->error($model,'import_id'); ?>
	</div>

	<div class="row">
		<br/>
		<fieldset >
		<legend>Data</legend>
		<?php echo $model->showAll(); ?>
		</fieldset>
		<?php echo $form->error($model,'data'); ?>
	</div>
	<fieldset>
	<legend>New Item field</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'match'); ?>
		<br/>
		<?php echo $form->radioButtonList($model,'match',array(1=>'Yes',0=>'No',2=>'Unde')); ?>
		<?php echo $form->error($model,'match'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sup_vsku'); ?>
		<?php echo $form->textField($model,'sup_vsku'); ?>
		<?php echo $form->error($model,'sup_vsku'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_sku'); ?>
		<?php echo $form->textField($model,'mfg_sku'); ?>
		<?php echo $form->error($model,'mfg_sku'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'upc'); ?>
		<?php echo $form->textField($model,'upc'); ?>
		<?php echo $form->error($model,'upc'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_name'); ?>
		<?php echo $form->textField($model,'mfg_name'); ?>
		<?php echo $form->error($model,'mfg_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_part_name'); ?>
		<?php echo $form->textField($model,'mfg_part_name'); ?>
		<?php echo $form->error($model,'mfg_part_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sup_sku'); ?>
		<?php echo $form->textField($model,'sup_sku'); ?>
		<?php echo $form->error($model,'sup_sku'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sup_sku_name'); ?>
		<?php echo $form->textField($model,'sup_sku_name'); ?>
		<?php echo $form->error($model,'sup_sku_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sup_description'); ?>
		<?php echo $form->textField($model,'sup_description'); ?>
		<?php echo $form->error($model,'sup_description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sup_price'); ?>
		<?php echo $form->textField($model,'sup_price'); ?>
		<?php echo $form->error($model,'sup_price'); ?>
	</div>
	
</fieldset>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->