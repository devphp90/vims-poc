<?php
$this->breadcrumbs=array(
	'Ubs Items'=>array('index'),
	'Inbound',
);
?>

<h1>Ubs Items Inbound</h1>

<div class="form">
	
	<script>
$(function(){
	$('#ImportRoutine_method_id').live('change',function(){
	
		var select = $(this);
		var newVal = select.val();
		$('fieldset[method=1]').hide();
		$('#method'+newVal).show();
	});
	
	$('#ImportRoutine2_method_id').live('change',function(){
	
		var select = $(this);
		var newVal = select.val();
		$('fieldset[method=2]').hide();
		$('#method2'+newVal).show();
	});
	
	$('input[name="ImportRoutine[price_type]"]').live('change',function(){
		console.log('123');
		var select = $(this);
		var newVal = select.val();
		if(newVal == 1){
			$('.sheet2').show();
			$('.default-price').hide();
			$('.map-price').html('MAP to Sheet2');
			$('.map-price-row').show();
		}else if(newVal == 2){
			$('.default-price').show();
			$('.sheet2').hide();
			$('.map-price').html('Set to Default Price');
			$('.map-price-row').hide();
		}else{
			$('.sheet2').hide();
			$('.default-price').hide();
			$('.map-price-row').show();
			$('.map-price').html('MAP to Sheet1');
		}
	});
});
</script>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'sup-inventory-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
	<?php echo $form->textFieldRow($model, 'file_name', array('hint'=>'')); ?>
	
	<?php echo $form->textFieldRow($model, 'zipped_file_name', array('hint'=>'')); ?>
		
	<?php echo $form->textFieldRow($model, 'delimiter'); ?>

	<?php echo $form->textFieldRow($model, 'enclosure'); ?>
	
	

	<?php echo $form->dropDownListRow($model,'unzip',array('none','zip','rar(not work)'), array('hint'=>''))?>
	
		<?php echo $form->dropDownListRow($model,'file_id',CHtml::listData(ImportFileType::model()->findAll(),'id','type'),array('hint'=>''))?>
	

		<?php echo $form->dropDownListRow($model,'method_id',CHtml::listData(ImportMethod::model()->findAll(),'id','type'), array('hint'=>''))?>
		<?php echo $form->dropDownListRow($model,'server_id',CHtml::listData(ImportRoutineServer::model()->findAll('status=1'),'id','name'), array('hint'=>''))?>
	
	
		<?php echo $form->textFieldRow($model,'frequency',array('hint'=>'')); ?>
		
		<?php echo $form->dropDownListRow($model,'frequency_option',array('Hour','Day','Minute'),array('hint'=>'')); ?>

		<?php echo $form->textFieldRow($model,'botime',array('append'=>'Day')); ?>


		<?php echo $form->dropDownListRow($model,'status',array('No','Yes'), array('hint'=>'')); ?>
	
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
	
	<div class="form-actions">
		<?php  
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit', 
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			'htmlOptions'=>array(
			),
		)); 
		
		$this->widget('bootstrap.widgets.TbButton',array(
			'label' => 'Cancel',
			'htmlOptions'=>array(
				'onclick'=>'js:location.href="../admin";',
			),
		));
		?>
		</div>
<?php $this->endWidget(); ?>
</div>