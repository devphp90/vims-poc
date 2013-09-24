
<?php echo $form->dropDownListRow($model,'uprice_override_status',array('inactive','active')); ?>
<?php echo $form->textFieldRow($model,'uprice_override_percent_change',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'uprice_override_start', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textFieldRow($model, 'uprice_override_end', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textAreaRow($model,'uprice_override_comment',array('class'=>'span2')); ?>

<hr/>
<?php echo $form->dropDownListRow($model,'uqty_override_status',array('inactive','active')); ?>
<?php echo $form->textFieldRow($model,'uqty_override_percent_change',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'uqty_override_start', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textFieldRow($model, 'uqty_override_end', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textAreaRow($model,'uqty_override_comment',array('class'=>'span2')); ?>
<hr/>
<?php echo $form->dropDownListRow($model,'uinventory_override_status',array('inactive','active')); ?>
<?php echo $form->textFieldRow($model,'uinventory_override_percent_change',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'uinventory_override_start', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textFieldRow($model, 'uinventory_override_end', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textAreaRow($model,'uinventory_override_comment',array('class'=>'span2')); ?>


