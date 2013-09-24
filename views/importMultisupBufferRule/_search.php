<?php
/* @var $this ImportMultisupBufferRuleController */
/* @var $model ImportMultisupBufferRule */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_qty'); ?>
		<?php echo $form->textField($model,'sup_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_qty'); ?>
		<?php echo $form->textField($model,'start_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_qty'); ?>
		<?php echo $form->textField($model,'end_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'from'); ?>
		<?php echo $form->textField($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->