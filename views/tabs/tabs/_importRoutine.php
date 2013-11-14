<script>
function opennewwin(){
	console.log($('#ImportRoutine_method_id').val());
	switch($('#ImportRoutine_method_id').val()){
		case '1':
			var url = $('#ImportRoutine_ftp_server').val().substring(0,6)+$('#ImportRoutine_ftp_username').val()+':'+$('#ImportRoutine_ftp_password').val()+'@'+$('#ImportRoutine_ftp_server').val().substring(6);
			console.log(url);
			//$('#ImportRoutine_ftp_server').val()
			//$('#ImportRoutine_ftp_username').val(),
			//$('#ImportRoutine_ftp_password').val()
			
			break;
		case '3':
			var url = $('#ImportRoutine_http_url').val().substring(0,7)+$('#ImportRoutine_http_username').val()+':'+$('#ImportRoutine_http_password').val()+'@'+$('#ImportRoutine_http_url').val().substring(7)+'/'+$('#ImportRoutine_ftp_path').val();
			console.log(url);
			break;
			
	}
	window.open( url , "_blank" );
	//
	
}

function opennewwin2(){

	switch($('#ImportRoutine2_method_id').val()){
		case '1':
			var url = $('#ImportRoutine2_ftp_server').val().substring(0,6)+$('#ImportRoutine2_ftp_username').val()+':'+$('#ImportRoutine2_ftp_password').val()+'@'+$('#ImportRoutine2_ftp_server').val().substring(6);
			console.log(url);
			//$('#ImportRoutine_ftp_server').val()
			//$('#ImportRoutine_ftp_username').val(),
			//$('#ImportRoutine_ftp_password').val()
			
			break;
		case '3':
			var url = $('#ImportRoutine2_http_url').val().substring(0,7)+$('#ImportRoutine2_http_username').val()+':'+$('#ImportRoutine2_http_password').val()+'@'+$('#ImportRoutine2_http_url').val().substring(7)+'/'+$('#ImportRoutine2_ftp_path').val();
			console.log(url);
			break;
			
	}
	window.open( url , "_blank" );
	//
	
}
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
	$('.testconnection1').click(function(){
		$.ajax({
			url: '/index.php/importRoutine/testconnection',
			data:{
				ImportRoutine_id: <?php echo $importRoutineModel->id?>,
				ImportRoutine_method_id: $('#ImportRoutine_method_id').val(),
				ImportRoutine_ftp_server: $('#ImportRoutine_ftp_server').val(),
				ImportRoutine_ftp_port: $('#ImportRoutine_ftp_port').val(),
				ImportRoutine_ftp_username: $('#ImportRoutine_ftp_username').val(),
				ImportRoutine_ftp_password: $('#ImportRoutine_ftp_password').val(),
				ImportRoutine_http_url: $('#ImportRoutine_http_url').val(),
				ImportRoutine_http_username: $('#ImportRoutine_http_username').val(),
				ImportRoutine_http_password: $('#ImportRoutine_http_password').val(),
			},
			success:function(data){
				alert(data);
			}
			
		});
	});
	$('.testconnection2').click(function(){
		$.ajax({
			url: '/index.php/importRoutine/testconnection',
			data:{
				ImportRoutine_id: <?php echo $importRoutineModel2->id?>,
				ImportRoutine_method_id: $('#ImportRoutine2_method_id').val(),
				ImportRoutine_ftp_server: $('#ImportRoutine2_ftp_server').val(),
				ImportRoutine_ftp_port: $('#ImportRoutine2_ftp_port').val(),
				ImportRoutine_ftp_username: $('#ImportRoutine2_ftp_username').val(),
				ImportRoutine_ftp_password: $('#ImportRoutine2_ftp_password').val(),
				ImportRoutine_http_url: $('#ImportRoutine2_http_url').val(),
				ImportRoutine_http_username: $('#ImportRoutine2_http_username').val(),
				ImportRoutine_http_password: $('#ImportRoutine2_http_password').val(),
			},
			success:function(data){
				alert(data);
			}
			
		});
	});
	$('#retrievedinfo').append('<a target="_blank" href="/index.php//importRoutine/getPartialSheet?id=<?php echo $importRoutineModel->id?>">8 row version</a>');
	$('#retrievedinfo2').append('<a target="_blank" href="/index.php//importRoutine/getPartialSheet?id=<?php echo $importRoutineModel2->id?>">8 row version</a>');
	$('.retrieve1').click(function(){

		$.ajax({
			url: '/index.php/importRoutine/retrieveSheet',
			data:{
				id: <?php echo $importRoutineModel->id?>
			},
			beforeSend:function(data){
				$('.retrived').html('Retrieving').show();
			},
			success: function(){
				$.ajax({
					url: '/index.php/importRoutine/getImportUrl',
					data:{
						id: <?php echo $importRoutineModel->id?>
					},
					success: function(data){
						$('.retrived').html('Retrieved File').attr('href',data);
					},
					
				});
			},
			
		});
	});
	$('.retrieve2').click(function(){

		$.ajax({
			url: '/index.php/importRoutine/retrieveSheet',
			data:{
				id: <?php echo $importRoutineModel2->id?>
			},
			beforeSend:function(data){
				$('.retrived2').html('Retrieving').show();
			},
			success: function(){
				$.ajax({
					url: '/index.php/importRoutine/getImportUrl',
					data:{
						id: <?php echo $importRoutineModel2->id?>
					},
					success: function(data){
						$('.retrived2').html('Retrieved File').attr('href',data);
					},
					
				});
			},
			
		});
	});
	
	$('.applydelimiter').click(function(){
		$.ajax({
			url: '/index.php/importRoutine/getcsv',
			data:{
				delimiter: $(".delimitervalue").val(),
				qualifer: $(".qualifervalue").val(),
				id: <?php echo $importRoutineModel->id?>,
			},

			success: function(data){
				$('.delimiterresult').html(data);
			}
		});
	});
	
});
</script>
<?php //echo $form->radioButtonListRow($importRoutineModel, 'price_type',array('price and qty combined','price and qty separate','qty only, UBS sets default price')); ?>
<div class="span5 well">
	<h4>Sheet 1 (Qty and Price, or Qty)</h4>
	
	<?php echo $form->dropDownListRow($importRoutineModel,'method_id',CHtml::listData(ImportMethod::model()->findAll("`using` = 1 order by `order` asc"),'id','type'), array('hint'=>''))?>
	
	<fieldset method="1" id="method1" <?php echo $importRoutineModel->method_id !=1?'style="display:none;"':''?>>
		<legend >FTP Setting</legend>
		
			<?php echo $form->textFieldRow($importRoutineModel, 'ftp_server'); ?>
			
			
			
			<?php echo $form->textFieldRow($importRoutineModel, 'ftp_port'); ?>

			<?php echo $form->textFieldRow($importRoutineModel, 'ftp_username'); ?>
			
			<?php echo $form->textFieldRow($importRoutineModel,'ftp_password'); ?>			
	</fieldset>
	<fieldset method="1" id="method2" <?php echo $importRoutineModel->method_id !=2?'style="display:none;"':''?>>
		<legend>Email Setting</legend>

			<?php echo $form->textFieldRow($importRoutineModel,'email_subject'); ?>

			<?php echo $form->textFieldRow($importRoutineModel,'email_sender'); ?>
		
	</fieldset>
	<fieldset method="1" id="method3" <?php echo $importRoutineModel->method_id !=3?'style="display:none;"':''?>>
		<legend>HTTP Setting</legend>

			<?php echo $form->textFieldRow($importRoutineModel,'http_url'); ?>

			<?php echo $form->textFieldRow($importRoutineModel,'http_username'); ?>

			<?php echo $form->textFieldRow($importRoutineModel,'http_password'); ?>
	</fieldset>
	<a class="pull-right btn btn-primary testconnection1" style="margin-right:75px;">Save and Test Connection</a>
	<div style="clear:both;"></div>
		<hr style="border-color:#e5e5e5;"/>
	<?php echo $form->textFieldRow($importRoutineModel, 'ftp_path'); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel, 'file_name', array('hint'=>'')); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel, 'zipped_file_name', array('hint'=>'')); ?>
	<input type="submit" class="btn btn-primary pull-right" value="Save" style="margin-right:70px;">
	<a onclick="opennewwin();" class="pull-right btn btn-primary browser1" style="margin-right:5px;">Browse</a>
	<div style="clear:both;"></div>
	<br/>
	<?php echo $form->dropDownListRow($importRoutineModel,'unzip',array('none','zip','rar(not work)'), array('hint'=>''))?>
	<?php echo $form->dropDownListRow($importRoutineModel,'file_id',CHtml::listData(ImportFileType::model()->findAll(),'id','type'),array('hint'=>''))?>
	<hr style="border-color:#e5e5e5;"/>
		<a class="retrived" target="_blank" href="#" style="display:none;">Retrieved File.</a>
		<div id="retrievedinfo"></div>
		<a class="pull-right btn btn-primary retrieve1" style="margin-right:75px;">Retrieve Sheet</a><br/><br/>
		<?php
				if($importRoutineModel->file_id ==1){
		?>
		<a class="pull-right btn btn-primary" style="margin-right:75px;" data-toggle='modal' data-target='#delimiter'>Choose Delimiter and Text Qualifier</a>
		<?php
		}
		?>
	<div style="clear:both;"></div>
	<hr style="border-color:#e5e5e5;"/>
	<?php echo $form->textFieldRow($importRoutineModel,'match_startby'); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel, 'delimiter'); ?>

	<?php echo $form->textFieldRow($importRoutineModel, 'enclosure'); ?>
	
	

	
	
		
	

		
		<?php echo $form->dropDownListRow($importRoutineModel,'server_id',CHtml::listData(ImportRoutineServer::model()->findAll('status=1'),'id','name'), array('hint'=>''))?>
	
	
		<?php echo $form->textFieldRow($importRoutineModel,'frequency',array('hint'=>'')); ?>
		
		<?php echo $form->dropDownListRow($importRoutineModel,'frequency_option',array('Hour','Day','Minute'),array('hint'=>'')); ?>

		<?php echo $form->textFieldRow($importRoutineModel,'days_to_disco',array('append'=>'Day')); ?>


		<?php echo $form->dropDownListRow($importRoutineModel,'status',array('No','Yes'), array('hint'=>'')); ?>
	
	
</div>

<?php

?>
<div class="row well span5 sheet2" style="<?php //echo $importRoutineModel2->price_type!=1?'display:none;':''?>">

	<h4>Sheet 2 (Price only)</h4>
	
	<?php echo $form->dropDownListRow($importRoutineModel2,'method_id',CHtml::listData(ImportMethod::model()->findAll(),'id','type'), array('hint'=>'','name'=>'ImportRoutine2[method_id]'))?>
	
	<fieldset method="2" id="method21" <?php echo $importRoutineModel2->method_id !=1?'style="display:none;"':''?>>
	<legend >FTP Setting</legend>
	
		<?php echo $form->textFieldRow($importRoutineModel2, 'ftp_server',array('name'=>'ImportRoutine2[ftp_server]')); ?>
		
		<?php echo $form->textFieldRow($importRoutineModel2, 'ftp_port',array('name'=>'ImportRoutine2[ftp_port]')); ?>

		<?php echo $form->textFieldRow($importRoutineModel2, 'ftp_username',array('name'=>'ImportRoutine2[ftp_username]')); ?>
		
		<?php echo $form->textFieldRow($importRoutineModel2,'ftp_password',array('name'=>'ImportRoutine2[ftp_password]')); ?>			
	</fieldset>
	<fieldset method="2" id="method22" <?php echo $importRoutineModel2->method_id !=2?'style="display:none;"':''?>>
		<legend>Email Setting</legend>

			<?php echo $form->textFieldRow($importRoutineModel2,'email_subject',array('name'=>'ImportRoutine2[email_subject]')); ?>

			<?php echo $form->textFieldRow($importRoutineModel2,'email_sender',array('name'=>'ImportRoutine2[email_sender]')); ?>
		
	</fieldset>
	<fieldset method="2" id="method23" <?php echo $importRoutineModel2->method_id !=3?'style="display:none;"':''?>>
		<legend>HTTP Setting</legend>

			<?php echo $form->textFieldRow($importRoutineModel2,'http_url',array('name'=>'ImportRoutine2[http_url]')); ?>

			<?php echo $form->textFieldRow($importRoutineModel2,'http_username',array('name'=>'ImportRoutine2[http_username]')); ?>

			<?php echo $form->textFieldRow($importRoutineModel2,'http_password',array('name'=>'ImportRoutine2[http_password]')); ?>

	</fieldset>
	<a class="pull-right btn btn-primary testconnection2" style="margin-right:75px;">Save and Test Connection</a>
	<div style="clear:both;"></div>
		<hr style="border-color:#e5e5e5;"/>
	<?php echo $form->textFieldRow($importRoutineModel2, 'ftp_path', array('name'=>'ImportRoutine2[ftp_path]')); ?>
	<?php echo $form->textFieldRow($importRoutineModel2, 'file_name', array('name'=>'ImportRoutine2[file_name]')); ?>
	
	<?php echo $form->textFieldRow($importRoutineModel2, 'zipped_file_name', array('name'=>'ImportRoutine2[zipped_file_name]')); ?>
	
	<input type="submit" class="btn btn-primary pull-right" value="Save" style="margin-right:70px;">
	<a  onclick="opennewwin2();" class="pull-right btn btn-primary browse2" style="margin-right:5px;">Browse</a>
	<div style="clear:both;"></div>
	<br/>
	<?php echo $form->dropDownListRow($importRoutineModel2,'unzip',array('none','zip','rar(not work)'), array('hint'=>'','name'=>'ImportRoutine2[unzip]'))?>
	<?php 

	echo $form->dropDownListRow($importRoutineModel2,'file_id',CHtml::listData(ImportFileType::model()->findAll(),'id','type'),array('hint'=>'','name'=>'ImportRoutine2[file_id]'));
	?>
	<hr style="border-color:#e5e5e5;"/>
		<a class="retrived2" target="_blank" href="#" style="display:none;">Retrieved File.</a>
		<div id="retrievedinfo2"></div>
		<a class="pull-right btn btn-primary retrieve2" style="margin-right:75px;">Retrieve Sheet</a><br/><br/>
		<?php
				if($importRoutineModel->file_id ==1){
		?>
		<a class="pull-right btn btn-primary" style="margin-right:75px;" data-toggle='modal' data-target='#delimiter'>Choose Delimiter and Text Qualifier</a>
		<?php
		}
		?>
	<div style="clear:both;"></div>
	<hr style="border-color:#e5e5e5;"/>
<?php echo $form->textFieldRow($importRoutineModel2,'match_startby',array('name'=>'ImportRoutine2[match_startby]')); ?>
	<?php echo $form->textFieldRow($importRoutineModel2, 'delimiter',array('name'=>'ImportRoutine2[delimiter]')); ?>

	<?php echo $form->textFieldRow($importRoutineModel2, 'enclosure',array('name'=>'ImportRoutine2[enclosure]')); ?>
	
	
	
	
	
	
	
	
	
	<?php echo $form->dropDownListRow($importRoutineModel2,'server_id',CHtml::listData(ImportRoutineServer::model()->findAll('status=1'),'id','name'), array('hint'=>'','name'=>'ImportRoutine2[server_id]'))?>

	<?php echo $form->textFieldRow($importRoutineModel2,'frequency',array('hint'=>'','name'=>'ImportRoutine2[frequency]')); ?>
	
	<?php echo $form->dropDownListRow($importRoutineModel2,'frequency_option',array('Hour','Day','Minute'),array('hint'=>'','name'=>'ImportRoutine2[frequency_option]')); ?>

	<?php echo $form->textFieldRow($importRoutineModel2,'days_to_disco',array('append'=>'Day','name'=>'ImportRoutine2[days_to_disco]',)); ?>

	<?php echo $form->dropDownListRow($importRoutineModel2,'status',array('No','Yes'), array('hint'=>'','name'=>'ImportRoutine2[status]')); ?>
	<div class="default-price" style="<?php echo $importRoutineModel2->price_type!=2?'':''?>">
	<?php echo $form->textFieldRow($importRoutineModel2, 'default_price',array('name'=>'ImportRoutine2[default_price]')); ?>
	</div>
	

</div>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'delimiter')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>

	
	<div class="modal-body">
		Delimiter:<input type="text" class="delimitervalue span1"  value=",">
		Text Qualifer<input type="text" class="qualifervalue span1" value='"'>
		<a class="btn applydelimiter" href="#">Apply</a>
		<?php
		if($importRoutineModel->file_id ==1){
		$sheet = new GetOriginSheet($importRoutineModel->id);

		foreach($sheet->getData() as $id=>$row){
			echo '<div class="delimiterrow">', CHtml::encode($row),'</div>';
		}
		}
		?>
		<hr/>
		<div class="delimiterresult">
			
		</div>
	</div>
 
	<div class="modal-footer">
	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>