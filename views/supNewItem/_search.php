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
		<?php echo $form->label($model,'sup_vsku'); ?>
		<?php echo $form->textField($model,'sup_vsku'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'sup_sku'); ?>
		<?php echo $form->textField($model,'sup_sku'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'sup_sku_name'); ?>
		<?php echo $form->textField($model,'sup_sku_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'sup_description'); ?>
		<?php echo $form->textField($model,'sup_description'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'mfg_sku'); ?>
		<?php echo $form->textField($model,'mfg_sku'); ?>
	</div>
<div class="row">
		<?php echo $form->label($model,'upc'); ?>
		<?php echo $form->textField($model,'upc'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'mfg_name'); ?>
		<?php echo $form->textField($model,'mfg_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'mfg_part_name'); ?>
		<?php echo $form->textField($model,'mfg_part_name'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->