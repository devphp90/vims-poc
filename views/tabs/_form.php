<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tabs-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'supplier_name',array('class'=>'span2')); ?>


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
