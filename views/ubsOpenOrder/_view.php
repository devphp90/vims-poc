<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cancelled')); ?>:</b>
	<?php echo CHtml::encode($data->Cancelled); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ItemNumber')); ?>:</b>
	<?php echo CHtml::encode($data->ItemNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Product')); ?>:</b>
	<?php echo CHtml::encode($data->Product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('QuantityOrdered')); ?>:</b>
	<?php echo CHtml::encode($data->QuantityOrdered); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved')); ?>:</b>
	<?php echo CHtml::encode($data->Approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ApprovalDate')); ?>:</b>
	<?php echo CHtml::encode($data->ApprovalDate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('OrderNumber')); ?>:</b>
	<?php echo CHtml::encode($data->OrderNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OrderDate')); ?>:</b>
	<?php echo CHtml::encode($data->OrderDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierName')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Phone')); ?>:</b>
	<?php echo CHtml::encode($data->Phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Email')); ?>:</b>
	<?php echo CHtml::encode($data->Email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SKU')); ?>:</b>
	<?php echo CHtml::encode($data->SKU); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Suppliers_SupplierID')); ?>:</b>
	<?php echo CHtml::encode($data->Suppliers_SupplierID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CartID')); ?>:</b>
	<?php echo CHtml::encode($data->CartID); ?>
	<br />

	*/ ?>

</div>