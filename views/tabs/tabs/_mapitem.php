<?php
$maphint = 'Map to Sheet1';

if($importRoutineModel->price_type == 1)
	$maphint = 'Map to Sheet1';
?>
<div class="span5">
	<h4>MAP - Sheet 1</h4>
	
	<?php echo $form->textFieldRow($importRoutineModel,'new_mfg_sku'); ?>
	
	<div class="map-price-row" style="style="<?php echo $importRoutineModel->price_type==2?'display:none;':''?>"">

			<?php echo $form->textFieldRow($importRoutineModel,'price',array()); ?>

	
	</div>
	
	<?php echo $form->textFieldRow($importRoutineModel,'default_price'); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel,'new_mfg_name'); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel,'new_mfg_part_name'); ?>
	
	
	
	<?php echo $form->textFieldRow($importRoutineModel,'new_upc'); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel,'min_adv_price'); ?>

	<?php echo $form->textFieldRow($importRoutineModel,'new_sup_sku'); ?>

	<?php echo $form->textFieldRow($importRoutineModel,'new_sup_sku_name'); ?>

	<?php echo $form->textFieldRow($importRoutineModel,'new_sup_description'); ?>
</div>
<div class="span5">
	<h4>MAP - Sheet 2</h4>
	
	
	<?php echo $form->textFieldRow($importRoutineModel2,'new_mfg_sku',array('name'=>'ImportRoutine2[new_mfg_sku]')); ?>
	
	<div class="map-price-row" style="style="<?php echo $importRoutineModel2->price_type==2?'display:none;':''?>"">

			<?php echo $form->textFieldRow($importRoutineModel2,'price',array('name'=>'ImportRoutine2[price]')); ?>

	
	</div>
	<?php echo $form->textFieldRow($importRoutineModel2,'min_adv_price',array('name'=>'ImportRoutine2[min_adv_price]')); ?>
<?php
/*
?>
<!--
	<?php echo $form->textFieldRow($importRoutineModel2,'new_mfg_name',array('name'=>'ImportRoutine2[new_mfg_name]')); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel2,'new_mfg_part_name',array('name'=>'ImportRoutine2[new_mfg_part_name]')); ?>
	
	
	
	<?php echo $form->textFieldRow($importRoutineModel2,'new_upc',array('name'=>'ImportRoutine2[new_upc]')); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel2,'min_adv_price',array('name'=>'ImportRoutine2[min_adv_price]')); ?>

	<?php echo $form->textFieldRow($importRoutineModel2,'new_sup_sku',array('name'=>'ImportRoutine2[new_sup_sku]')); ?>

	<?php echo $form->textFieldRow($importRoutineModel2,'new_sup_sku_name',array('name'=>'ImportRoutine2[new_sup_sku_name]')); ?>

	<?php echo $form->textFieldRow($importRoutineModel2,'new_sup_description',array('name'=>'ImportRoutine2[new_sup_description]')); ?>
-->
<?php
*/
?>
</div>
<?php

?>

