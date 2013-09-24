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
<div class="row">

	<?php echo $form->textFieldRow($model, 'supplier_name', array('hint'=>'<font color="green">Required for Import/Update.</font>',)); ?>


	<?php echo $form->textFieldRow($model, 'file_name', array('hint'=>'<font color="green">Required for Import/Update.</font>')); ?>
		
	<?php echo $form->textFieldRow($model, 'delimiter'); ?>

	<?php echo $form->textFieldRow($model, 'enclosure'); ?>
	
	<?php echo $form->dropDownListRow($model,'unzip',array('none','zip','rar(not work)'), array('hint'=>'<font color="green">Required for Import/Update.</font>'))?>
	
		<?php echo $form->dropDownListRow($model,'file_id',CHtml::listData(ImportFileType::model()->findAll(),'id','type'),array('hint'=>'<font color="green">Required for Import/Update.</font>'))?>
	

		<?php echo $form->dropDownListRow($model,'method_id',CHtml::listData(ImportMethod::model()->findAll(),'id','type'), array('hint'=>'<font color="green">Required for Import/Update.</font>'))?>
		<?php echo $form->dropDownListRow($model,'server_id',CHtml::listData(ImportRoutineServer::model()->findAll('status=1'),'id','name'), array('hint'=>'<font color="green">Required for Import/Update.</font>'))?>
	
	
		<?php echo $form->textFieldRow($model,'frequency',array('hint'=>'<font color="green">Required for Import/Update.</font>')); ?>
		
		<?php echo $form->dropDownListRow($model,'frequency_option',array('Hour','Day','Minute'),array('hint'=>'<font color="green">Required for Import/Update.</font>')); ?>

		<?php echo $form->textFieldRow($model,'botime',array('append'=>'Day')); ?>


		<?php echo $form->dropDownListRow($model,'status',array('No','Yes'), array('hint'=>'<font color="green">Required for Import/Update.</font>')); ?>
	
	<fieldset method="1" id="method1" <?php echo $model->method_id !=1?'style="display:none;"':''?>>
		<legend >FTP Setting</legend>
		
			<?php echo $form->textFieldRow($model, 'ftp_server'); ?>
			
			<?php echo $form->textFieldRow($model, 'ftp_port'); ?>

			<?php echo $form->textFieldRow($model, 'ftp_username'); ?>
			
			<?php echo $form->textFieldRow($model,'ftp_password'); ?>			
	</fieldset>
	<fieldset method="1" id="method2" <?php echo $model->method_id !=2?'style="display:none;"':''?>>
		<legend>Email Setting</legend>

			<?php echo $form->textFieldRow($model,'email_subject'); ?>

			<?php echo $form->textFieldRow($model,'email_sender'); ?>
		
	</fieldset>
	<fieldset method="1" id="method3" <?php echo $model->method_id !=3?'style="display:none;"':''?>>
		<legend>HTTP Setting</legend>

			<?php echo $form->textFieldRow($model,'http_url'); ?>

			<?php echo $form->textFieldRow($model,'http_username'); ?>

			<?php echo $form->textFieldRow($model,'http_password'); ?>

	</fieldset>

	</div>
<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScript('mytext', "jQuery('#ImportRoutine_supplier_name').autocomplete({'source':'/index.php/supplier/autocompleteSup'});");
?>