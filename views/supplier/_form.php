<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'contact'); ?>
		<?php echo $form->textArea($model,'contact'); ?>
		<?php echo $form->error($model,'contact'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'loc_id'); ?>
		<?php echo $form->textField($model,'loc_id'); ?>
		<?php echo $form->error($model,'loc_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rating'); ?>
		<?php echo $form->textField($model,'rating'); ?>
		<?php echo $form->error($model,'rating'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'cancel_rate'); ?>
		<?php echo $form->textField($model,'cancel_rate'); ?>
		<?php echo $form->error($model,'cancel_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'percent_change'); ?>
		<?php echo $form->textField($model,'percent_change'); ?>
		<?php echo $form->error($model,'percent_change'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'ubs_act_exec'); ?>
		<?php echo $form->textField($model,'ubs_act_exec',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'ubs_act_exec'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model,'active',array('inactive','active')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	
	<div class="row buttons">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->