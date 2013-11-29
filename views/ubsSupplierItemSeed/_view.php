<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierName')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierID')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SKU')); ?>:</b>
	<?php echo CHtml::encode($data->SKU); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MPN')); ?>:</b>
	<?php echo CHtml::encode($data->MPN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upc')); ?>:</b>
	<?php echo CHtml::encode($data->upc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierSKU')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierSKU); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ItemName')); ?>:</b>
	<?php echo CHtml::encode($data->ItemName); ?>
	<br />

	*/ ?>

</div>