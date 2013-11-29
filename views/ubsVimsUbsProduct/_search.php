<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ubs_sku',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_ubs_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vims_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_mpn',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_upc',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_manufacturer',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_item_description',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_price',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_map_price',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_our_cost',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_qoh',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'primary_supplier_vsheet_sku',array('class'=>'span5','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'sale_price',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sale_qoh',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'dtCreated',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
