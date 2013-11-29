<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ubs_sku')); ?>:</b>
	<?php echo CHtml::encode($data->ubs_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_ubs_id')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_ubs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vims_id')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vims_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_mpn')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_mpn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_upc')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_upc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_manufacturer); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_item_description')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_item_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_price')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_map_price')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_map_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_our_cost')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_our_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_qoh')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_qoh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_supplier_vsheet_sku')); ?>:</b>
	<?php echo CHtml::encode($data->primary_supplier_vsheet_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_price')); ?>:</b>
	<?php echo CHtml::encode($data->sale_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_qoh')); ?>:</b>
	<?php echo CHtml::encode($data->sale_qoh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtCreated')); ?>:</b>
	<?php echo CHtml::encode($data->dtCreated); ?>
	<br />

	*/ ?>

</div>