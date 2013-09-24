<?php
/*
	
	?>
<div class="radio">
	<?php echo $form->labelEx($importroutineModel,'new_map_by'); ?>
	<?php echo $form->radioButtonList($importroutineModel,'new_map_by',array('Column #','Field name'),array('separator'=>'','labelOptions'=>array('style'=>'display:inline'))); ?>
	<?php echo $form->error($importroutineModel,'new_map_by'); ?>
</div>
<?php
*/
?>

<fieldset>
	<legend>New Item #</legend>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'match_startby'); ?>
		<?php echo $form->textField($importroutineModel,'match_startby'); ?>
		<?php echo $form->error($importroutineModel,'match_startby'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'price'); ?>
		<?php echo $form->textField($importroutineModel,'price'); ?>
		<?php echo $form->error($importroutineModel,'price'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'min_adv_price'); ?>
		<?php echo $form->textField($importroutineModel,'min_adv_price'); ?>
		<?php echo $form->error($importroutineModel,'min_adv_price'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_mfg_sku'); ?>
		<?php echo $form->textField($importroutineModel,'new_mfg_sku'); ?>
		<?php echo $form->error($importroutineModel,'new_mfg_sku'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_upc'); ?>
		<?php echo $form->textField($importroutineModel,'new_upc'); ?>
		<?php echo $form->error($importroutineModel,'new_upc'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_mfg_name'); ?>
		<?php echo $form->textField($importroutineModel,'new_mfg_name'); ?>
		<?php echo $form->error($importroutineModel,'new_mfg_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_mfg_part_name'); ?>
		<?php echo $form->textField($importroutineModel,'new_mfg_part_name'); ?>
		<?php echo $form->error($importroutineModel,'new_mfg_part_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_sup_sku'); ?>
		<?php echo $form->textField($importroutineModel,'new_sup_sku'); ?>
		<?php echo $form->error($importroutineModel,'new_sup_sku'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_sup_sku_name'); ?>
		<?php echo $form->textField($importroutineModel,'new_sup_sku_name'); ?>
		<?php echo $form->error($importroutineModel,'new_sup_sku_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'new_sup_description'); ?>
		<?php echo $form->textField($importroutineModel,'new_sup_description'); ?>
		<?php echo $form->error($importroutineModel,'new_sup_description'); ?>
	</div>
	<?php echo CHtml::submitButton('importroutineSave'); ?>
	
</fieldset>

