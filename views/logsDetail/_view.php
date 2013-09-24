<?php
/* @var $this LogsDetailController */
/* @var $data LogsDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_id')); ?>:</b>
	<?php echo CHtml::encode($data->log_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('step')); ?>:</b>
	<?php echo CHtml::encode($data->step); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />


</div>