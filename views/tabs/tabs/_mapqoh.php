<?php
$warehouseData = CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($importRoutineModel->sup_id)),'id','name');
?>
<div>

	<?php echo $form->radioButtonListRow($importRoutineModel,'qoh_type',array('Number','Yes/No, Default Amount: '),array('separator'=>'','labelOptions'=>array('style'=>'display:inline'))); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel,'default_qty'); ?>
	
	
	<div>
		<?php echo $form->textFieldRow($importRoutineModel,'ware_1'); ?>

		<?php echo $form->textFieldRow($importRoutineModel,'ware_2'); ?>

		<?php echo $form->textFieldRow($importRoutineModel,'ware_3'); ?>

		<?php echo $form->textFieldRow($importRoutineModel,'ware_4'); ?>

		<?php echo $form->textFieldRow($importRoutineModel,'ware_5'); ?>

		<?php echo $form->textFieldRow($importRoutineModel,'ware_6'); ?>
	</div>
	<div>
		<?php echo $form->dropDownListRow($importRoutineModel,'ware_id_1',$warehouseData)?>

		<?php echo $form->dropDownListRow($importRoutineModel,'ware_id_2',$warehouseData)?>

		<?php echo $form->dropDownListRow($importRoutineModel,'ware_id_3',$warehouseData)?>

		<?php echo $form->dropDownListRow($importRoutineModel,'ware_id_4',$warehouseData)?>

		<?php echo $form->dropDownListRow($importRoutineModel,'ware_id_5',$warehouseData)?>

		<?php echo $form->dropDownListRow($importRoutineModel,'ware_id_6',$warehouseData)?>
	</div>
</div>
