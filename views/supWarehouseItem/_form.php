<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sup-warehouse-item-form',
	'enableAjaxValidation'=>false,
)); 
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ware_id'); ?>
		<?php echo $form->dropDownList($model,'ware_id',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_inventory->sup_id)),'id','name'))?>
		<?php echo $form->error($model,'ware_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'qty_on_hand'); ?>
		<?php echo $form->textField($model,'qty_on_hand'); ?>
		<?php echo $form->error($model,'qty_on_hand'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->