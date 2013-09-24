<?php
/* @var $this ImportSupMarkupController */
/* @var $model ImportSupMarkup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-sup-markup-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_name'); ?>
		<?php

		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'ImportSupMarkup[supplier_name]',
			'value'=>!empty($model->supplier->id)?$model->supplier->name:'',
			'model'=>$model,
			'source'=>$this->createUrl('/supplier/autocompleteSup'),
			'options'=>array(
				//'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}',
			),

		));

		?>
		<?php echo $form->error($model,'supplier_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from'); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'markup'); ?>
		<?php echo $form->textField($model,'markup'); ?>
		<?php echo $form->error($model,'markup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array('$','%'))?>    
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'break_map'); ?>
		<?php echo $form->dropDownList($model,'break_map',array('No','Yes'))?>    
		<?php echo $form->error($model,'break_map'); ?>
	</div>


	<div class="row buttons">
		<?php  echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
		array('onclick'=>'js:$("#'.get_class($model).'_sup_id").val($("#'.get_class($model).'_sup_id").val().match(/(-\d+)/)[0].replace("-",""));'));  ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->