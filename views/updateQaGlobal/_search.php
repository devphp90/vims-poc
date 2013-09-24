<?php
/* @var $this UpdateQaGlobalController */
/* @var $model UpdateQaGlobal */
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
		<?php echo $form->label($model,'item_percent'); ?>
		<?php echo $form->textField($model,'item_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instock_percent'); ?>
		<?php echo $form->textField($model,'instock_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qoh_percent'); ?>
		<?php echo $form->textField($model,'qoh_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_percent'); ?>
		<?php echo $form->textField($model,'price_percent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->