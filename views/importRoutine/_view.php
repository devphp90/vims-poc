<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_id')); ?>:</b>
	<?php echo CHtml::encode($data->sup_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('method_id')); ?>:</b>
	<?php echo CHtml::encode($data->method_id); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('file_id')); ?>:</b>
	<?php echo CHtml::encode($data->file_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_name')); ?>:</b>
	<?php echo CHtml::encode($data->file_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('match_column')); ?>:</b>
	<?php echo CHtml::encode($data->match_column); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_match_column')); ?>:</b>
	<?php echo CHtml::encode($data->sup_match_column); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inventory_column')); ?>:</b>
	<?php echo CHtml::encode($data->inventory_column); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('match_field')); ?>:</b>
	<?php echo CHtml::encode($data->match_field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sup_match_field')); ?>:</b>
	<?php echo CHtml::encode($data->sup_match_field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inventory_field')); ?>:</b>
	<?php echo CHtml::encode($data->inventory_field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_field')); ?>:</b>
	<?php echo CHtml::encode($data->price_field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('frequency')); ?>:</b>
	<?php echo CHtml::encode($data->frequency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>

</div>