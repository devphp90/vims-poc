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
		<?php echo $form->label($model,'sup_name'); ?>
		<?php echo $form->textField($model,'sup_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'import_method'); ?>
		<?php echo $form->textField($model,'import_method'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'file_name'); ?>
		<?php echo $form->textField($model,'file_name',array('size'=>-1,'maxlength'=>-1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'match_column'); ?>
		<?php echo $form->textField($model,'match_column'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_match_column'); ?>
		<?php echo $form->textField($model,'sup_match_column'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model,'frequency'); ?>
		<?php echo $form->textField($model,'frequency',array('size'=>-1,'maxlength'=>-1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>-1,'maxlength'=>-1)); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->