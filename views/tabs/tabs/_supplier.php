
<?php echo $form->hiddenField($supplierModel, 'ubs_supplier_id')?>
<div class="control-group">
	<?php echo $form->label($supplierModel, 'ubsSupplierName', array('class'=>'control-label'))?>
	<div class="controls">
		
		<?php echo $form->textField($supplierModel, 'ubsSupplierName', array('readonly' => 'readonly'))?>
		<?php $this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'label' => 'Choose...',
				'type' => 'success',
				'htmlOptions' => array(
					'onclick' => 'js:$("#ubsSupplierModal").dialog("open");'
				),));
		?>
	</div>
</div>
<div style="display:none">
 <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'ubsSupplierModal',
            // additional javascript options for the dialog plugin
            'options' => array(
                'width' => '900',
                'height' => '500',
                'title' => 'UBS Suppliers',
                'autoOpen' => false,
                'buttons' => array(
                    array('text' => 'Cancel', 'click' => 'js:function(){ $(this).dialog("close"); }'),
                ),
            ),
        ));
        ?>

<?php 
$ubs = new UbsSupplier('search');
$ubs->unsetAttributes();
if(isset($_REQUEST['UbsSupplier']))
	$ubs->attributes = $_REQUEST['UbsSupplier'];

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ubs-supplier-grid',
	'dataProvider'=>$ubs->search(),
	'filter'=>$ubs,
	'columns'=>array(
		array(
			'header' => 'Select',
			'type' => 'raw',
			'value' => 'CHtml::link("Select", "javascript:void(0)", array("data-id" => $data->SupplierID, "data-name" => $data->SupplierName, "class" => "btn btn-small btn-success select-ubs"));'
		),
		'SupplierID',
		'SupplierName',
		'City',
		'Country',
		'Email',
		/*
		'Fax',
		'Phone',
		'TollFreePhone',
		'MainContact',
		'MainContactPhone',
		'Phone_2',
		'TimeStamp',
		'Phone2',
		*/
		
	),
)); ?>

<?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
</div>
<?php echo $form->textFieldRow($supplierModel,'name',array('class'=>'span2')); ?>

<?php echo $form->textFieldRow($supplierModel,'email',array('class'=>'span2')); ?>




<?php echo $form->textFieldRow($supplierModel,'phone',array('class'=>'span2')); ?>


<?php echo $form->dropDownListRow($supplierModel,'active',array('inactive','active')); ?>



<?php echo $form->textAreaRow($supplierModel,'note',array('class'=>'span2')); ?>
<?php echo $form->dropDownListRow($supplierModel,'setup_status',array('I' => 'Incomplete', 'C' =>  'Complete'), array('class'=>'span2')); ?>
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

<script>
	$('.select-ubs').live('click', function () {
		id = $(this).attr('data-id');
		name = $(this).attr('data-name');
		$('#Supplier_ubsSupplierName').val(name);
		$('#Supplier_ubs_supplier_id').val(id);
		$('#ubsSupplierModal').dialog('close');
		
	});

</script>