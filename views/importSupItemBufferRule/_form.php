
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'import-sup-item-buffer-rule-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'supplier_name'); ?>
	
	<?php echo $form->textFieldRow($model, 'ubs_sku',array('hint'=>'<font color="green">Exact value required.</font>')); ?>

	<?php echo $form->textFieldRow($model,'from'); ?>
	


	<?php echo $form->textFieldRow($model,'to'); ?>


	<?php echo $form->textFieldRow($model,'qty'); ?>


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
Yii::app()->clientScript->registerScript('mytext', "jQuery('#ImportSupItemBufferRule_supplier_name').autocomplete({'source':'/index.php/supplier/autocompleteSup'});");

?>