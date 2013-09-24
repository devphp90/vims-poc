
<?php echo $form->dropDownListRow($model,'price_override_status',array('inactive','active')); ?>
<?php echo $form->textFieldRow($model,'price_override_percent_change',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'price_override_start', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textFieldRow($model, 'price_override_end', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textAreaRow($model,'price_override_comment',array('class'=>'span2')); ?>

<hr/>
<?php echo $form->dropDownListRow($model,'qty_override_status',array('inactive','active')); ?>
<?php echo $form->textFieldRow($model,'qty_override_percent_change',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model, 'qty_override_start', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textFieldRow($model, 'qty_override_end', array('prepend'=>'<i class="icon-calendar"></i>')); ?>
<?php echo $form->textAreaRow($model,'qty_override_comment',array('class'=>'span2')); ?>


