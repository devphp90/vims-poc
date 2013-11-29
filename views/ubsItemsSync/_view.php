<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku')); ?>:</b>
	<?php echo CHtml::encode($data->sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_part_number')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_part_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upc')); ?>:</b>
	<?php echo CHtml::encode($data->upc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('our_cost')); ?>:</b>
	<?php echo CHtml::encode($data->our_cost); ?>
	<br />


</div>