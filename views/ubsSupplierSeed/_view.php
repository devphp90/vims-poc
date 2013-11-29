<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SupplierID),array('view','id'=>$data->SupplierID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupplierName')); ?>:</b>
	<?php echo CHtml::encode($data->SupplierName); ?>
	<br />


</div>