<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabs_id')); ?>:</b>
	<?php echo CHtml::encode($data->tabs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_integrity_status')); ?>:</b>
	<?php echo CHtml::encode($data->data_integrity_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_integrity_reason')); ?>:</b>
	<?php echo CHtml::encode($data->data_integrity_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh_item_percent_change_status')); ?>:</b>
	<?php echo CHtml::encode($data->qoh_item_percent_change_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh_item_percent_change_reason')); ?>:</b>
	<?php echo CHtml::encode($data->qoh_item_percent_change_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_item_percent_change_status')); ?>:</b>
	<?php echo CHtml::encode($data->price_item_percent_change_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('price_item_percent_change_reason')); ?>:</b>
	<?php echo CHtml::encode($data->price_item_percent_change_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instock_item_status')); ?>:</b>
	<?php echo CHtml::encode($data->instock_item_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instock_item_reason')); ?>:</b>
	<?php echo CHtml::encode($data->instock_item_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh_percent_change_status')); ?>:</b>
	<?php echo CHtml::encode($data->qoh_percent_change_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh_percent_change_reason')); ?>:</b>
	<?php echo CHtml::encode($data->qoh_percent_change_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_percent_change_status')); ?>:</b>
	<?php echo CHtml::encode($data->price_percent_change_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_percent_change_reason')); ?>:</b>
	<?php echo CHtml::encode($data->price_percent_change_reason); ?>
	<br />

	*/ ?>

</div>