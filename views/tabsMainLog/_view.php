<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabs_id')); ?>:</b>
	<?php echo CHtml::encode($data->tabs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sheet1_file_size')); ?>:</b>
	<?php echo CHtml::encode($data->sheet1_file_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sheet2_file_size')); ?>:</b>
	<?php echo CHtml::encode($data->sheet2_file_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sheet1_row')); ?>:</b>
	<?php echo CHtml::encode($data->sheet1_row); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sheet2_row')); ?>:</b>
	<?php echo CHtml::encode($data->sheet2_row); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>