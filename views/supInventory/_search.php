<?php
/* @var $this SupInventoryController */
/* @var $model SupInventory */
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
		<?php echo $form->label($model,'ubs_id'); ?>
		<?php echo $form->textField($model,'ubs_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_id'); ?>
		<?php echo $form->textField($model,'sup_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_sku'); ?>
		<?php echo $form->textField($model,'sup_sku',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_sku_name'); ?>
		<?php echo $form->textField($model,'sup_sku_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_description'); ?>
		<?php echo $form->textField($model,'sup_description',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_price'); ?>
		<?php echo $form->textField($model,'sup_price'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'priceFrom'); ?>
		<?php echo $form->textField($model,'priceFrom'); ?>
		To
		<?php echo $form->textField($model,'priceTo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_vsku'); ?>
		<?php echo $form->textField($model,'sup_vsku',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_vqoh'); ?>
		<?php echo $form->textField($model,'sup_vqoh'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sup_status'); ?>
		<?php echo $form->textField($model,'sup_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mfg_sku'); ?>
		<?php echo $form->textField($model,'mfg_sku',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mfg_sku_plain'); ?>
		<?php echo $form->textField($model,'mfg_sku_plain',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mfg_name'); ?>
		<?php echo $form->textField($model,'mfg_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mfg_sku_name'); ?>
		<?php echo $form->textField($model,'mfg_sku_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'mpnFrom'); ?>
		<?php echo $form->textField($model,'mpnFrom'); ?>
		To
		<?php echo $form->textField($model,'mpnTo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mfg_upc'); ?>
		<?php echo $form->textField($model,'mfg_upc',array('size'=>60,'maxlength'=>100)); ?>
	</div>
<!--

	<div class="row">
		<?php echo $form->label($model,'last_update'); ?>
		<?php echo $form->textField($model,'last_update'); ?>
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
-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->