<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'action',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'ubs_sku',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'supplier_ubs_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'supplier_name',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'mpn',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'upc',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'supplier_sku',array('class'=>'span5','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'ubs_manufacturer',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'item_description',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'our_cost',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'qoh',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'dtCreated',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
