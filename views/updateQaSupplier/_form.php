<?php
/* @var $this UpdateQaSupplierController */
/* @var $model UpdateQaSupplier */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'update-qa-supplier-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'supplier_name'); ?>
	
	<?php echo $form->textFieldRow($model,'item_percent'); ?>

	<?php echo $form->textFieldRow($model,'instock_percent'); ?>

	<?php echo $form->textFieldRow($model,'di_qoh_percent'); ?>

	<?php echo $form->textFieldRow($model,'di_price_percent'); ?>

	<?php echo $form->textFieldRow($model,'qoh_percent'); ?>
	
	<?php echo $form->textFieldRow($model,'price_percent'); ?>


	<div class="form-actions">
		<?php  
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit', 
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			'htmlOptions'=>array(
			),
		)); 
		
		$this->widget('bootstrap.widgets.TbButton',array(
			'label' => 'Cancel',
			'htmlOptions'=>array(
				'onclick'=>'js:location.href="../admin";',
			),
		));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScript('mytext', "jQuery('#UpdateQaSupplier_supplier_name').autocomplete({'source':'/index.php/supplier/autocompleteSup'});");
?>