<?php
/* @var $this ImportMultisupBufferRuleController */
/* @var $data ImportMultisupBufferRule */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_qty')); ?>:</b>
	<?php echo CHtml::encode($data->sup_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_qty')); ?>:</b>
	<?php echo CHtml::encode($data->start_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_qty')); ?>:</b>
	<?php echo CHtml::encode($data->end_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to')); ?>:</b>
	<?php echo CHtml::encode($data->to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from')); ?>:</b>
	<?php echo CHtml::encode($data->from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />


</div>