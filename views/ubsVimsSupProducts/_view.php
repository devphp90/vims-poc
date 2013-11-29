<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
	<?php echo CHtml::encode($data->action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ubs_sku')); ?>:</b>
	<?php echo CHtml::encode($data->ubs_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_ubs_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_ubs_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_name')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mpn')); ?>:</b>
	<?php echo CHtml::encode($data->mpn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upc')); ?>:</b>
	<?php echo CHtml::encode($data->upc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_sku')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ubs_manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->ubs_manufacturer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_description')); ?>:</b>
	<?php echo CHtml::encode($data->item_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('our_cost')); ?>:</b>
	<?php echo CHtml::encode($data->our_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoh')); ?>:</b>
	<?php echo CHtml::encode($data->qoh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtCreated')); ?>:</b>
	<?php echo CHtml::encode($data->dtCreated); ?>
	<br />

	*/ ?>

</div>