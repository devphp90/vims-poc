
<div id="warehouse" class="span10">	

	<?php echo $form->radioButtonListRow($model,'qoh_type',array('Number','Yes/No'),array('separator'=>'','labelOptions'=>array('style'=>'display:inline'))); ?>
		<?php echo $form->radioButtonListRow($model,'match_column',array('Column #','Field name'),array('separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','labelOptions'=>array('style'=>'display:inline'))); ?>

		
	
		<?php echo $form->textFieldRow($model,'ware_1'); ?>

		<?php echo $form->textFieldRow($model,'ware_2'); ?>

		<?php echo $form->textFieldRow($model,'ware_3'); ?>

		<?php echo $form->textFieldRow($model,'ware_4'); ?>

		<?php echo $form->textFieldRow($model,'ware_5'); ?>

		<?php echo $form->textFieldRow($model,'ware_6'); ?>
	
		<?php echo $form->dropDownListRow($model,'ware_id_1',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_id)),'id','name'))?>

		<?php echo $form->dropDownListRow($model,'ware_id_2',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_id)),'id','name'))?>

		<?php echo $form->dropDownListRow($model,'ware_id_3',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_id)),'id','name'))?>

		<?php echo $form->dropDownListRow($model,'ware_id_4',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_id)),'id','name'))?>

		<?php echo $form->dropDownListRow($model,'ware_id_5',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_id)),'id','name'))?>

		<?php echo $form->dropDownListRow($model,'ware_id_6',CHtml::listData(SupWarehouse::model()->findAll('sup_id=?',array($model->sup_id)),'id','name'))?>

</div>
