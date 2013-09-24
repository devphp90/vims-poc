

	<fieldset>
	<legend>Link to UBS SKU</legend>
		<?php echo $form->textFieldRow($model, 'ubs_sku', array('hint'=>'<font color="green">Exact value required. Server side validation on Save.</font>',)); ?>
	</fieldset>
	<fieldset name="Supplier Info" title="">
	<legend>Supplier Info</legend>

	<?php echo $form->textFieldRow($model, 'supplier_name', array('hint'=>'<font color="green">Required for Import/Update.</font>',)); ?>
	
	<?php echo $form->textFieldRow($model, 'sup_vsku', array('hint'=>'<font color="green">Required for Import/Update.</font>')); ?>
	
	<?php echo $form->textFieldRow($model, 'sup_sku'); ?>
	
	<?php echo $form->textFieldRow($model, 'sup_sku_name'); ?>
	
	<?php echo $form->textAreaRow($model,'sup_description'); ?>
	
	<?php echo $form->textFieldRow($model,'sup_price', array('prepend'=>'$')); ?>
	
	<?php echo $form->textFieldRow($model,'sup_min_adv_price', array('prepend'=>'$','hint'=>'Mininum Advertised Price')); ?>
	
	<?php echo $form->dropDownListRow($model,'sup_status',array('DISCO','INSTOCK','BO'))?>    

	<?php echo $form->textFieldRow($model,'sup_open_order'); ?>
		
	<?php echo $form->textFieldRow($model,'qty_total'); ?>
	
	<?php echo $form->textFieldRow($model,'sup_vqoh'); ?>
	<?php echo $form->textFieldRow($model,'cancel_rate_limit'); ?>
	</fieldset>
	

	
	<fieldset name="Manufacturer Info" title="">
	<legend>Manufacturer Info</legend>
		<?php echo $form->textFieldRow($model,'mfg_sku'); ?>
		
		<?php echo $form->textFieldRow($model,'mfg_sku_plain'); ?>
		
		<?php echo $form->textFieldRow($model,'mfg_upc'); ?>
		
		<?php echo $form->textFieldRow($model,'mfg_name'); ?>
		
		<?php echo $form->textFieldRow($model,'mfg_sku_name'); ?>
		
	</fieldset>
	<fieldset name="OverRide Info" title="">
	<legend>OverRide Info</legend>
		<?php echo $form->textFieldRow($model,'uprice'); ?>
		
		<?php echo $form->textFieldRow($model,'umap'); ?>
		
		<?php echo $form->textFieldRow($model,'uqty'); ?>

		<?php echo $form->dropDownListRow($model,'item_status',array('Inactive','Active'))?>    
	</fieldset>
