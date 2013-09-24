<script>
$(function(){
	$('#ImportRoutine_method_id').live('change',function(){
	
		var select = $(this);
		var newVal = select.val();
		$('fieldset[method=1]').hide();
		$('#method'+newVal).show();
	});
	
});
</script>
<h1>Setup New Import Routine</h1><hr/><br/>

	<?php echo $form->errorSummary($importroutineModel); ?>

	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'file_name'); ?>
		<?php echo $form->textField($importroutineModel,'file_name',array('size'=>35)); ?>
		<?php echo $form->error($importroutineModel,'file_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'delimiter'); ?>
		<?php echo $form->textField($importroutineModel,'delimiter',array('size'=>6)); ?>
		<?php echo $form->error($importroutineModel,'delimiter'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'enclosure'); ?>
		<?php echo $form->textField($importroutineModel,'enclosure',array('size'=>6)); ?>
		<?php echo $form->error($importroutineModel,'enclosure'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'unzip'); ?>
		<?php echo $form->dropDownList($importroutineModel,'unzip',array('none','zip','rar(not work)'))?>
		<font color="green">*</font>
		<?php echo $form->error($importroutineModel,'unzip'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'file_id',array('label'=>'Sheet Type')); ?>
		<?php echo $form->dropDownList($importroutineModel,'file_id',CHtml::listData(ImportFileType::model()->findAll(),'id','type'))?>
		<?php echo $form->error($importroutineModel,'file_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'method_id',array('label'=>'Method')); ?>
		<?php echo $form->dropDownList($importroutineModel,'method_id',CHtml::listData(ImportMethod::model()->findAll(),'id','type'))?>
		<?php echo $form->error($importroutineModel,'method_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'server_id',array('label'=>'Server')); ?>
		<?php echo $form->dropDownList($importroutineModel,'server_id',CHtml::listData(ImportRoutineServer::model()->findAll('status=1'),'id','name'))?>
		<?php echo $form->error($importroutineModel,'server_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'frequency',array('label'=>'Frequency')); ?>
		<?php echo $form->textField($importroutineModel,'frequency'); ?>
		<?php echo $form->dropDownList($importroutineModel,'frequency_option',array('Hour','Day','Minute')); ?>
		<?php echo $form->error($importroutineModel,'frequency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'botime',array('label'=>'Change To Disco after')); ?>
		<?php echo $form->textField($importroutineModel,'botime'); ?> Day
		<?php echo $form->error($importroutineModel,'botime'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($importroutineModel,'status',array('label'=>'Auto Import/Update')); ?>
		<?php echo $form->dropDownList($importroutineModel,'status',array('No','Yes')); ?>
		<?php echo $form->error($importroutineModel,'status'); ?>
	</div>
	<fieldset method="1" id="method1" <?php echo $importroutineModel->method_id !=1?'style="display:none;"':''?>>
		<legend >FTP Setting</legend>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'ftp_server'); ?>
			<?php echo $form->textField($importroutineModel,'ftp_server'); ?>
			<?php echo $form->error($importroutineModel,'ftp_server'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'ftp_port'); ?>
			<?php echo $form->textField($importroutineModel,'ftp_port'); ?>
			<?php echo $form->error($importroutineModel,'ftp_port'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'ftp_username'); ?>
			<?php echo $form->textField($importroutineModel,'ftp_username'); ?>
			<?php echo $form->error($importroutineModel,'ftp_username'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'ftp_password'); ?>
			<?php echo $form->textField($importroutineModel,'ftp_password'); ?>
			<?php echo $form->error($importroutineModel,'ftp_password'); ?>
		</div>
	</fieldset>
	<fieldset method="1" id="method2" <?php echo $importroutineModel->method_id !=2?'style="display:none;"':''?>>
		<legend>Email Setting</legend>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'email_subject'); ?>
			<?php echo $form->textField($importroutineModel,'email_subject'); ?>
			<?php echo $form->error($importroutineModel,'email_subject'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'email_sender'); ?>
			<?php echo $form->textField($importroutineModel,'email_sender'); ?>
			<?php echo $form->error($importroutineModel,'email_sender'); ?>
		</div>
		
	</fieldset>
	<fieldset method="1" id="method3" <?php echo $importroutineModel->method_id !=3?'style="display:none;"':''?>>
		<legend>HTTP Setting</legend>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'http_url'); ?>
			<?php echo $form->textField($importroutineModel,'http_url'); ?>
			<?php echo $form->error($importroutineModel,'http_url'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'http_username'); ?>
			<?php echo $form->textField($importroutineModel,'http_username'); ?>
			<?php echo $form->error($importroutineModel,'http_username'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($importroutineModel,'http_password'); ?>
			<?php echo $form->textField($importroutineModel,'http_password'); ?>
			<?php echo $form->error($importroutineModel,'http_password'); ?>
		</div>
	</fieldset>

	<?php echo CHtml::submitButton('importroutineSave'); ?>
