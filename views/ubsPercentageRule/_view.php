<?php
/* @var $this UbsPercentageRuleController */
/* @var $data UbsPercentageRule */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_price')); ?>:</b>
	<?php echo CHtml::encode($data->start_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_price')); ?>:</b>
	<?php echo CHtml::encode($data->end_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percent')); ?>:</b>
	<?php echo CHtml::encode($data->percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diff')); ?>:</b>
	<?php echo CHtml::encode($data->diff); ?>
	<br />


</div>