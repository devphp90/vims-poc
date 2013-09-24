<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku')); ?>:</b>
	<?php echo CHtml::encode($data->sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku_name')); ?>:</b>
	<?php echo CHtml::encode($data->sku_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh')); ?>:</b>
	<?php echo CHtml::encode($data->qoh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>