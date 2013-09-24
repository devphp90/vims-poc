<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating')); ?>:</b>
	<?php echo CHtml::encode($data->rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ubs_act_exec')); ?>:</b>
	<?php echo CHtml::encode($data->ubs_act_exec); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_active')); ?>:</b>
	<?php echo CHtml::encode($data->sup_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_term_date')); ?>:</b>
	<?php echo CHtml::encode($data->sup_term_date); ?>
	<br />

	*/ ?>

</div>