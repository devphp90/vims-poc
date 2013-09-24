
<div class="span5">
	<h4>Match - Sheet 1</h4>
		
		VIMS Supplier SKU value (VSKU#) is made-up by UBS<br/>
		VSKU is the unique indentifier for an Update Sheet row.<br/>
		What column # in the Update Sheet makes the best VSKU?<br/>
		VSKU lives as a field in Supplier Item table and serves as the Match value between an Update Sheet row and a Supplier Item record.<br/>
		<br/>
		<?php echo $form->labelEx($importRoutineModel,'sup_match_column',array('label'=>'VSKU = Col #','style'=>'margin-right:0px;text-align:left;min-width:100px;display:inline')); ?>
		<?php echo $form->textField($importRoutineModel,'sup_match_column',array('size'=>'3','class'=>'input-mini')); ?>
		<?php echo $form->error($importRoutineModel,'sup_match_column'); ?>

		+
		<?php echo $form->labelEx($importRoutineModel,'sup_match_column_1',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;display:inline;')); ?>
		<?php echo $form->textField($importRoutineModel,'sup_match_column_1',array('size'=>'3','class'=>'input-mini')); ?>
		<?php echo $form->error($importRoutineModel,'sup_match_column_1'); ?>

		+
		<?php echo $form->labelEx($importRoutineModel,'sup_match_column_2',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;display:inline;')); ?>
		<?php echo $form->textField($importRoutineModel,'sup_match_column_2',array('size'=>'3','class'=>'input-mini')); ?>
		<?php echo $form->error($importRoutineModel,'sup_match_column_2'); ?>


	
	</div>
<!--
<div class="span5">
	<h4>Match - Sheet 1</h4>
		
		VIMS Supplier SKU value (VSKU#) is made-up by UBS<br/>
		VSKU is the unique indentifier for an Update Sheet row.<br/>
		What column # in the Update Sheet makes the best VSKU?<br/>
		VSKU lives as a field in Supplier Item table and serves as the Match value between an Update Sheet row and a Supplier Item record.<br/>
		<br/>
		<?php echo $form->labelEx($importRoutineModel2,'sup_match_column',array('label'=>'VSKU = Col #','style'=>'margin-right:0px;text-align:left;min-width:100px;display:inline')); ?>
		<?php echo $form->textField($importRoutineModel2,'sup_match_column',array('size'=>'3','class'=>'input-mini','name'=>'ImportRoutine2[delimiter]')); ?>
		<?php echo $form->error($importRoutineModel2,'sup_match_column'); ?>

		+
		<?php echo $form->labelEx($importRoutineModel2,'sup_match_column_1',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;display:inline;')); ?>
		<?php echo $form->textField($importRoutineModel2,'sup_match_column_1',array('size'=>'3','class'=>'input-mini','name'=>'ImportRoutine2[delimiter]')); ?>
		<?php echo $form->error($importRoutineModel2,'sup_match_column_1'); ?>

		+
		<?php echo $form->labelEx($importRoutineModel2,'sup_match_column_2',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;display:inline;')); ?>
		<?php echo $form->textField($importRoutineModel2,'sup_match_column_2',array('size'=>'3','class'=>'input-mini','name'=>'ImportRoutine2[delimiter]')); ?>
		<?php echo $form->error($importRoutineModel2,'sup_match_column_2'); ?>


	
	</div>
-->
	<?php
	/*
	?>
<div class="span5">

		
		VIMS Supplier SKU value (VSKU#) is made-up by UBS<br/>
		VSKU is the unique indentifier for an Update Sheet row.<br/>
		What column # in the Update Sheet makes the best VSKU?<br/>
		VSKU lives as a field in Supplier Item table and serves as the Match value between an Update Sheet row and a Supplier Item record.<br/>
		<br/>
		<?php echo $form->labelEx($importRoutineModel,'sup_match_column',array('label'=>'VSKU = Col #','style'=>'margin-right:0px;text-align:left;min-width:100px;display:inline')); ?>
		<?php echo $form->textField($importRoutineModel,'sup_match_column',array('size'=>'3','class'=>'input-mini')); ?>
		<?php echo $form->error($importRoutineModel,'sup_match_column'); ?>

		+
		<?php echo $form->labelEx($importRoutineModel,'sup_match_column_1',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;display:inline;')); ?>
		<?php echo $form->textField($importRoutineModel,'sup_match_column_1',array('size'=>'3','class'=>'input-mini')); ?>
		<?php echo $form->error($importRoutineModel,'sup_match_column_1'); ?>

		+
		<?php echo $form->labelEx($importRoutineModel,'sup_match_column_2',array('label'=>'Col #','style'=>'margin-right:0px;text-align:left;min-width:10px;display:inline;')); ?>
		<?php echo $form->textField($importRoutineModel,'sup_match_column_2',array('size'=>'3','class'=>'input-mini')); ?>
		<?php echo $form->error($importRoutineModel,'sup_match_column_2'); ?>


	
	</div>
	<?php
	*/
	?>