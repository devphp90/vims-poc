<?php
/* @var $this ImportSupBufferRuleController */
/* @var $model ImportSupBufferRule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-sup-buffer-rule-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_name'); ?>
		<?php
        echo $form->textField($model, 'supplier_name');
		/*$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'attribute'=>'ImportSupBufferRule[supplier_name]',
//			'value'=>!empty($model->supplier->id)?$model->supplier->name:'',
			'model'=>$model,
			'source'=>$this->createUrl('/supplier/autocompleteSup'),
			'options'=>array(
				//'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}',
			),

		));*/

		?>
		<?php echo $form->error($model,'supplier_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from'); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScript('mytext', "jQuery('#ImportSupBufferRule_supplier_name').autocomplete({'source':'/index.php/supplier/autocompleteSup'});");

?>