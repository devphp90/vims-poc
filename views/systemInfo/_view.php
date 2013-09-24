<?php
/* @var $this SystemInfoController */
/* @var $data SystemInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cancel_rate_limit')); ?>:</b>
	<?php echo CHtml::encode($data->cancel_rate_limit); ?>
	<br />


</div>