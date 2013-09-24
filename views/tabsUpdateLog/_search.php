<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tabs_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'data_integrity_status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'data_integrity_reason',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'qoh_item_percent_change_status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'qoh_item_percent_change_reason',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'price_item_percent_change_status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'price_item_percent_change_reason',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'instock_item_status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'instock_item_reason',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'qoh_percent_change_status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'qoh_percent_change_reason',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'price_percent_change_status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'price_percent_change_reason',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
