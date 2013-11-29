<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'dtCreated',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'Action',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'Completed',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'SKU',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'salePrice',array('class'=>'span5','maxlength'=>29)); ?>

	<?php echo $form->textFieldRow($model,'manufacturer',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'MPN',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'upc',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'ourCost',array('class'=>'span5','maxlength'=>29)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
