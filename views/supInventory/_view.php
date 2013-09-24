<?php
/* @var $this SupInventoryController */
/* @var $data SupInventory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ubs_id')); ?>:</b>
	<?php echo CHtml::encode($data->ubs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_id')); ?>:</b>
	<?php echo CHtml::encode($data->sup_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_sku')); ?>:</b>
	<?php echo CHtml::encode($data->sup_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_sku_name')); ?>:</b>
	<?php echo CHtml::encode($data->sup_sku_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_description')); ?>:</b>
	<?php echo CHtml::encode($data->sup_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_price')); ?>:</b>
	<?php echo CHtml::encode($data->sup_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_vsku')); ?>:</b>
	<?php echo CHtml::encode($data->sup_vsku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_vqoh')); ?>:</b>
	<?php echo CHtml::encode($data->sup_vqoh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_status')); ?>:</b>
	<?php echo CHtml::encode($data->sup_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfg_sku')); ?>:</b>
	<?php echo CHtml::encode($data->mfg_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfg_sku_plain')); ?>:</b>
	<?php echo CHtml::encode($data->mfg_sku_plain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfg_name')); ?>:</b>
	<?php echo CHtml::encode($data->mfg_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfg_sku_name')); ?>:</b>
	<?php echo CHtml::encode($data->mfg_sku_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfg_upc')); ?>:</b>
	<?php echo CHtml::encode($data->mfg_upc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_update')); ?>:</b>
	<?php echo CHtml::encode($data->last_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>

</div>