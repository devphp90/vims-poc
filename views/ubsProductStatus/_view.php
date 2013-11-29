<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtCreated')); ?>:</b>
	<?php echo CHtml::encode($data->dtCreated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Action')); ?>:</b>
	<?php echo CHtml::encode($data->Action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Completed')); ?>:</b>
	<?php echo CHtml::encode($data->Completed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SKU')); ?>:</b>
	<?php echo CHtml::encode($data->SKU); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('StockStatusID')); ?>:</b>
	<?php echo CHtml::encode($data->StockStatusID); ?>
	<br />


</div>