<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(

	'id'=>'ubs-items-sync-form',

	'enableAjaxValidation'=>false,

)); ?>


	<p class="help-block">Fields with <span class="required">*</span> are required.</p>



	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->textFieldRow($model,'sku',array('class'=>'span5','maxlength'=>32)); ?>


	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

<?php echo $form->textFieldRow($model,'sale_price',array('class'=>'span5','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'manufacturer',array('class'=>'span5','maxlength'=>255)); ?>


	<?php echo $form->textFieldRow($model,'manufacturer_part_number',array('class'=>'span5','maxlength'=>32)); ?>


	<?php echo $form->textFieldRow($model,'upc',array('class'=>'span5','maxlength'=>20)); ?>


	<?php echo $form->textFieldRow($model,'our_cost',array('class'=>'span5','maxlength'=>10)); ?>


	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(

			'buttonType'=>'submit',

			'type'=>'primary',

			'label'=>$model->isNewRecord ? 'Create' : 'Save',

		)); ?>
	</div>



<?php $this->endWidget(); ?>
