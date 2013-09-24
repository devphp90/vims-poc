<?php
/* @var $this ImportSupItemBufferRuleController */
/* @var $data ImportSupItemBufferRule */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_id')); ?>:</b>
	<?php echo CHtml::encode($data->sup_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ubs_id')); ?>:</b>
	<?php echo CHtml::encode($data->ubs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from')); ?>:</b>
	<?php echo CHtml::encode($data->from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to')); ?>:</b>
	<?php echo CHtml::encode($data->to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />


</div>