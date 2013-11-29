<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tabs_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet1_file_size',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet2_file_size',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet1_row',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sheet2_row',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
