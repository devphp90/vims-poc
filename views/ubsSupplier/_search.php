<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'SupplierID',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'SupplierName',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'Address1',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Address2',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'City',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'State',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Zip',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Country',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Email',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Fax',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Phone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'TollFreePhone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'MainContact',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'MainContactPhone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Phone_2',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'TimeStamp',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'Phone2',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
