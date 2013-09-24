<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ubs-inventory-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sku'); ?>
		<?php echo $form->textField($model,'sku'); ?>
		<font color="red">*</font><font color="green">*</font>
		<?php echo $form->error($model,'sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sku_name'); ?>
		<?php echo $form->textField($model,'sku_name'); ?>
		<?php echo $form->error($model,'sku_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'sku_description'); ?>
		<?php echo $form->textArea($model,'sku_description'); ?>
		<?php echo $form->error($model,'sku_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vprice'); ?>
		<?php echo $form->textField($model,'vprice'); ?>
		<?php echo $form->error($model,'vprice'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_title'); ?>
		<?php echo $form->textField($model,'mfg_title'); ?>
		<?php echo $form->error($model,'mfg_title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mfg_web_site_url'); ?>
		<?php echo $form->textField($model,'mfg_web_site_url'); ?>
		<?php echo $form->error($model,'mfg_web_site_url'); ?>
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
		<?php echo $form->labelEx($model,'upc'); ?>
		<?php echo $form->textField($model,'upc'); ?>
		<?php echo $form->error($model,'upc'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'qoh'); ?>
		<?php echo $form->textField($model,'qoh'); ?>
		<?php echo $form->error($model,'qoh'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
	
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php echo CHtml::button('Cancel',array('onclick'=>'js:history.go(-1);'))?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->