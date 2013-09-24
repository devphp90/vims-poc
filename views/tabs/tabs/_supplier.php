

<?php echo $form->textFieldRow($supplierModel,'name',array('class'=>'span2')); ?>

<?php echo $form->textFieldRow($supplierModel,'email',array('class'=>'span2')); ?>




<?php echo $form->textFieldRow($supplierModel,'phone',array('class'=>'span2')); ?>


<?php echo $form->dropDownListRow($supplierModel,'active',array('inactive','active')); ?>



<?php echo $form->textAreaRow($supplierModel,'note',array('class'=>'span2')); ?>
<h4>Options and Preferences</h4>
<hr/>
<?php echo $form->dropDownListRow($supplierModel,'timestamp',array('Off','On'),array('hint'=>'If On, VIMS will check the sheet date/time stamp and NOT Import if date/time has not changed since last Import.',)); ?>

<?php echo $form->textFieldRow($supplierModel,'ubs_email',array('class'=>'span2')); ?>


<?php echo $form->dropDownListRow($supplierModel,'email_ubs_if_fail',array('Off','On')); ?>
<?php echo $form->dropDownListRow($supplierModel,'email_supplier_if_fail',array('Off','On')); ?>

<?php echo $form->textFieldRow($supplierModel,'fail_message',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($supplierModel,'ignore_from',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($supplierModel,'ignore_to',array('class'=>'span2')); ?>
<?php //echo $form->textFieldRow($supplierModel,'cancel_rate',array('class'=>'span2')); ?>

