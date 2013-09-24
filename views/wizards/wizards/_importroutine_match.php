<script>
$(function(){
	
	$('input:radio[name="ImportRoutine[match_column]"]').live('change',function(){
		$('fieldset[match=1]').hide();
		$('#match'+$(this).val()).show();
	});
});

</script>
<div id="mapping">

	
		VIMS Supplier SKU value (VSKU#) is made-up by UBS<br/>
		VSKU is the unique indentifier for an Update Sheet row.<br/>
		What column # in the Update Sheet makes the best VSKU?<br/>
		VSKU lives as a field in Supplier Item table and serves as the Match value between an Update Sheet row and a Supplier Item record.<br/>
		<br/>
		<?php echo $form->labelEx($importroutineModel,'sup_match_column',array('label'=>'VSKU = Col #','style'=>'margin-right:0px;text-align:left;min-width:100px;')); ?>
		<?php echo $form->textField($importroutineModel,'sup_match_column',array('size'=>'3')); ?>
		<?php echo $form->error($importroutineModel,'sup_match_column'); ?>

		+
		<?php echo $form->labelEx($importroutineModel,'sup_match_column_1',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;')); ?>
		<?php echo $form->textField($importroutineModel,'sup_match_column_1',array('size'=>'3')); ?>
		<?php echo $form->error($importroutineModel,'sup_match_column_1'); ?>

		+
		<?php echo $form->labelEx($importroutineModel,'sup_match_column_2',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;')); ?>
		<?php echo $form->textField($importroutineModel,'sup_match_column_2',array('size'=>'3')); ?>
		<?php echo $form->error($importroutineModel,'sup_match_column_2'); ?>

		<br/>
		<?php echo CHtml::submitButton('importroutineSave'); ?>
	</div>