<?php
/* @var $this LogsController */
/* @var $model Logs */
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
		<?php echo $form->label($model,'import_id'); ?>
		<?php echo $form->textField($model,'import_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'sup_name'); ?>
		<?php echo $form->textField($model,'sup_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'import_status'); ?>
		<?php echo $form->textField($model,'import_status',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_size'); ?>
		<?php echo $form->textField($model,'file_size'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_number'); ?>
		<?php echo $form->textField($model,'item_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->