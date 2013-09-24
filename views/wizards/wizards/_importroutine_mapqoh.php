<?php

?>
<div id="warehouse">	
	<div class="radio">
	<?php echo $form->labelEx($importroutineModel,'qoh_type',array('label'=>'How does Supplier provide QOH?')); ?>
	<?php echo $form->radioButtonList($importroutineModel,'qoh_type',array('Number','Yes/No'),array('separator'=>'','labelOptions'=>array('style'=>'display:inline'))); ?>
	<?php echo $form->error($importroutineModel,'qoh_type'); ?>
	</div>
	<?php
/*
	
	?>
	<div class="radio">
		<?php echo $form->labelEx($importroutineModel,'match_column'); ?>
		<?php echo $form->radioButtonList($importroutineModel,'match_column',array('Column #','Field name'),array('separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','labelOptions'=>array('style'=>'display:inline'))); ?>
		<?php echo $form->error($importroutineModel,'match_column'); ?>
	</div>
	<?php
	
*/
	?>
<fieldset match="1" id="match0">
	<legend>Column # Match</legend>

	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_1'); ?>
		<?php echo $form->textField($importroutineModel,'ware_1'); ?>
		<?php echo $form->error($importroutineModel,'ware_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_2'); ?>
		<?php echo $form->textField($importroutineModel,'ware_2'); ?>
		<?php echo $form->error($importroutineModel,'ware_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_3'); ?>
		<?php echo $form->textField($importroutineModel,'ware_3'); ?>
		<?php echo $form->error($importroutineModel,'ware_3'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_4'); ?>
		<?php echo $form->textField($importroutineModel,'ware_4'); ?>
		<?php echo $form->error($importroutineModel,'ware_4'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_5'); ?>
		<?php echo $form->textField($importroutineModel,'ware_5'); ?>
		<?php echo $form->error($importroutineModel,'ware_5'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_6'); ?>
		<?php echo $form->textField($importroutineModel,'ware_6'); ?>
		<?php echo $form->error($importroutineModel,'ware_6'); ?>
	</div>
	</fieldset>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_id_1'); ?>
		<?php echo $form->dropDownList($importroutineModel,'ware_id_1',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($supplierModel->id)),'id','name'))?>
		<?php echo $form->error($importroutineModel,'ware_id_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_id_2'); ?>
		<?php echo $form->dropDownList($importroutineModel,'ware_id_2',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($supplierModel->id)),'id','name'))?>
		<?php echo $form->error($importroutineModel,'ware_id_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_id_3'); ?>
		<?php echo $form->dropDownList($importroutineModel,'ware_id_3',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($supplierModel->id)),'id','name'))?>
		<?php echo $form->error($importroutineModel,'ware_id_3'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_id_4'); ?>
		<?php echo $form->dropDownList($importroutineModel,'ware_id_4',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($supplierModel->id)),'id','name'))?>
		<?php echo $form->error($importroutineModel,'ware_id_4'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_id_5'); ?>
		<?php echo $form->dropDownList($importroutineModel,'ware_id_5',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($supplierModel->id)),'id','name'))?>
		<?php echo $form->error($importroutineModel,'ware_id_5'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'ware_id_6'); ?>
		<?php echo $form->dropDownList($importroutineModel,'ware_id_6',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($supplierModel->id)),'id','name'))?>
		<?php echo $form->error($importroutineModel,'ware_id_6'); ?>
	</div>
	<?php echo CHtml::submitButton('importroutineSave'); ?>
</div>