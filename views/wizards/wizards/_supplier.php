<h1>Setup New Supplier</h1><hr/><br/>

	<?php echo $form->errorSummary($supplierModel); ?>
	<div class="row">
		<?php echo $form->labelEx($supplierModel,'name'); ?>
		<?php echo $form->textField($supplierModel,'name',array('size'=>30,'maxlength'=>50)); ?>
		<?php echo $form->error($supplierModel,'name'); ?>
	</div>
	<?php echo CHtml::submitButton('supplierSave'); ?>