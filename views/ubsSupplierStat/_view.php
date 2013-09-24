<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SupplierId),array('view','id'=>$data->SupplierId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierName')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OrderCount')); ?>:</b>
	<?php echo CHtml::encode($data->OrderCount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OrderCount_Last30Days')); ?>:</b>
	<?php echo CHtml::encode($data->OrderCount_Last30Days); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Shipdays_OrderCount')); ?>:</b>
	<?php echo CHtml::encode($data->Shipdays_OrderCount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ShipDays')); ?>:</b>
	<?php echo CHtml::encode($data->ShipDays); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ShipDays_AllUnder30')); ?>:</b>
	<?php echo CHtml::encode($data->ShipDays_AllUnder30); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('BusinessShipDays')); ?>:</b>
	<?php echo CHtml::encode($data->BusinessShipDays); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BusinessShipDays_allunder30')); ?>:</b>
	<?php echo CHtml::encode($data->BusinessShipDays_allunder30); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ShipDays_Last30Days')); ?>:</b>
	<?php echo CHtml::encode($data->ShipDays_Last30Days); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CancelOrderCount')); ?>:</b>
	<?php echo CHtml::encode($data->CancelOrderCount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CancelRate')); ?>:</b>
	<?php echo CHtml::encode($data->CancelRate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CancelRate_Last30Days')); ?>:</b>
	<?php echo CHtml::encode($data->CancelRate_Last30Days); ?>
	<br />

	*/ ?>

</div>