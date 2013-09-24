<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sup-stats4-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sup_id'); ?>
		<?php echo $form->dropDownList($model,'sup_id',CHtml::listData(Supplier::model()->findAll('id<1000'),'id','name'))?>    #<?php echo $model->sup_id?><br/>
		<?php echo $form->error($model,'sup_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'cancel_rate'); ?>
		<?php echo $form->textField($model,'cancel_rate'); ?>
		<?php echo $form->error($model,'cancel_rate'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->