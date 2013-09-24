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
		<?php echo $form->label($model,'sku'); ?>
		<?php echo $form->textField($model,'sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sku_name'); ?>
		<?php echo $form->textField($model,'sku_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'upc'); ?>
		<?php echo $form->textField($model,'upc'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->