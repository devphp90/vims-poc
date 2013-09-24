<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'Cancelled',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ItemNumber',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'Product',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'QuantityOrdered',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'Approved',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ApprovalDate',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'OrderNumber',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'OrderDate',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'Name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'SupplierName',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'Phone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Email',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'SKU',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Suppliers_SupplierID',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'CartID',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
