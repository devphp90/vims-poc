<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabs_id')); ?>:</b>
	<?php echo CHtml::encode($data->tabs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_sheet1_status')); ?>:</b>
	<?php echo CHtml::encode($data->download_sheet1_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_sheet1_reason')); ?>:</b>
	<?php echo CHtml::encode($data->download_sheet1_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_sheet2_status')); ?>:</b>
	<?php echo CHtml::encode($data->download_sheet2_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_sheet2_reason')); ?>:</b>
	<?php echo CHtml::encode($data->download_sheet2_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_integrity_status')); ?>:</b>
	<?php echo CHtml::encode($data->data_integrity_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('data_integrity_reason')); ?>:</b>
	<?php echo CHtml::encode($data->data_integrity_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('overall_item_status')); ?>:</b>
	<?php echo CHtml::encode($data->overall_item_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('overall_item_reason')); ?>:</b>
	<?php echo CHtml::encode($data->overall_item_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finish_time')); ?>:</b>
	<?php echo CHtml::encode($data->finish_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>