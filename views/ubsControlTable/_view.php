<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('TableId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->TableId),array('view','id'=>$data->TableId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TableName')); ?>:</b>
	<?php echo CHtml::encode($data->TableName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DateLastUpdate')); ?>:</b>
	<?php echo CHtml::encode($data->DateLastUpdate); ?>
	<br />


</div>