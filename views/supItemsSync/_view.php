<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UbsSupplierName')); ?>:</b>
	<?php echo CHtml::encode($data->UbsSupplierName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UbsSupplierID')); ?>:</b>
	<?php echo CHtml::encode($data->UbsSupplierID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mpn')); ?>:</b>
	<?php echo CHtml::encode($data->Mpn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Upc')); ?>:</b>
	<?php echo CHtml::encode($data->Upc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierSku')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierSku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ItemName')); ?>:</b>
	<?php echo CHtml::encode($data->ItemName); ?>
	<br />


</div>