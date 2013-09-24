<?php
/* @var $this UpdateQaSupplierController */
/* @var $data UpdateQaSupplier */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_id')); ?>:</b>
	<?php echo CHtml::encode($data->sup_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_percent')); ?>:</b>
	<?php echo CHtml::encode($data->item_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instock_percent')); ?>:</b>
	<?php echo CHtml::encode($data->instock_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh_percent')); ?>:</b>
	<?php echo CHtml::encode($data->qoh_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_percent')); ?>:</b>
	<?php echo CHtml::encode($data->price_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<?php /*
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