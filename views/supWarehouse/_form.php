

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sup-warehouse-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sup_id'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>get_class($model).'[sup_id]',
			'value'=>!empty($model->supplier->id)?$model->supplier->name.'-'.$model->supplier->id:'',
			'model'=>$model,
			'source'=>$this->createUrl('/supplier/autocompleteSup'),
		));
		?>
		<font color="red">*</font><font color="green">*</font>
		<?php echo $form->error($model,'sup_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<font color="green">*</font>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state'); ?>
		<font color="green">*</font>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zip_code'); ?>
		<?php echo $form->textField($model,'zip_code'); ?>
		<?php echo $form->error($model,'zip_code'); ?>
	</div>

	<div class="row buttons">
		<?php  echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
		array('onclick'=>'js:$("#'.get_class($model).'_sup_id").val($("#'.get_class($model).'_sup_id").val().match(/(-\d+)/)[0].replace("-",""));'));  ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->