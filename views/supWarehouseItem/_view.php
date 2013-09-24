<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ware_id')); ?>:</b>
	<?php echo CHtml::encode($data->ware_id); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_on_hand')); ?>:</b>
	<?php echo CHtml::encode($data->qty_on_hand); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>