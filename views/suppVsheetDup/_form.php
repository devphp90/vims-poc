<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'supp-vsheet-dup-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'import_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sup_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet_type',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_type',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sup_vsku',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'map',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ware_1',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ware_2',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ware_3',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ware_4',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ware_5',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ware_6',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'mfg_sku',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'mfg_name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'mfg_part_name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'upc',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'sup_sku',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'sup_sku_name',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
