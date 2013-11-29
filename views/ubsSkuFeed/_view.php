<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SKU')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SKU),array('view','id'=>$data->SKU)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salePrice')); ?>:</b>
	<?php echo CHtml::encode($data->salePrice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('MPN')); ?>:</b>
	<?php echo CHtml::encode($data->MPN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upc')); ?>:</b>
	<?php echo CHtml::encode($data->upc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ourCost')); ?>:</b>
	<?php echo CHtml::encode($data->ourCost); ?>
	<br />

	*/ ?>

</div>