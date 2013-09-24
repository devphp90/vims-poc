<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<style>
.draggable { width: 100px; height: 20px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
#droppable { width: 150px; height: 50px; padding: 0.5em; float: left; margin: 10px; }
</style>
<script>
  $(function() {

    $( ".draggable" ).draggable();
    $( ".droppable" ).droppable({
    	hoverClass: "ui-state-active",
    	drop: function( event, ui ) {
	    	$(this).addClass( "ui-state-highlight" ).find( "p" ).html( $(this).attr(":field_name") + " Matched! - " + ui.draggable.attr(':sheet_field'));
	    	$('#' + $(this).attr(":field")).val(ui.draggable.attr(':sheet_num'));
	    	

	    	if($(this).attr(":field") == "ImportRoutine_new_mfg_sku")
	    		$('#ImportRoutine_sup_match_column').val(ui.draggable.attr(':sheet_num'));
	    	if($(this).attr(":field") == 'ImportRoutine_new_upc')
	    		$('#ImportRoutine_sup_match_column_1').val(ui.draggable.attr(':sheet_num'));
	    	if($(this).attr(":field") == "ImportRoutine2_new_mfg_sku")
	    		$('#ImportRoutine2_sup_match_column').val(ui.draggable.attr(':sheet_num'));
	    	if($(this).attr(":field") == 'ImportRoutine2_new_upc')
	    		$('#ImportRoutine2_sup_match_column_1').val(ui.draggable.attr(':sheet_num'));
	    		
//	    	$( this ).droppable( "option", "disabled", true );
	    },
	    out: function( event, ui){
	      	$(this).removeClass( "ui-state-highlight" ).find( "p" ).html( $(this).attr(":field_name") );

	      	$('#' + $(this).attr(":field")).val('');
//	      	$( this ).droppable( "option", "disabled", false );
	    }
    });
    
  });
  </script>
<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$column = unserialize(base64_decode($importRoutineModel->fetch_column));
$column2 = unserialize(base64_decode($importRoutineModel2->fetch_column));
?>
<div class="row">
	<div class="span5">
	
		<?php
	echo CHtml::ajaxLink('Import Remote Sheet',array('/importRoutine/importsheet'),array('update'=>'#drag-data','data'=>array('id'=>$importRoutineModel->id),'beforeSend'=>'function(){$(".progress_1").show();}','success'=>'function(){$(".progress_1").hide();}'),array('class'=>'btn btn-primary import-sheet','style'=>'margin-left:20px;margin-bottom:20px;'));
	
	?>
	<div style="display:none;" class="progress_1">
		processing...
	</div>
	
		<iframe style=" width:500px;height:100px;" frameborder="0" src="<?php echo $this->createUrl('importRoutine/fetchColumn',array('id'=>$importRoutineModel->id))?>">
		
	</iframe>
		<?php
/*
		echo CHtml::ajaxLink('Import Remote Sheet',array('/importRoutine/importsheet'),array('update'=>'#drag-data','data'=>array('id'=>$importRoutineModel->id)),array('class'=>'btn btn-primary import-sheet'));
		?>
	<br/>
	
	<?php
	
	//	echo CHtml::beginForm(array('/importRoutine/fetchColumn/'.$model->id),'post',array(
	//		'enctype'=>'multipart/form-data',
	//		));
		echo CHtml::fileField('file','',array());
	
		echo CHtml::submitButton('Import Local Sheet',array('class'=>'btn btn-primary'));
	
*/
		//echo CHtml::endForm();	
	?>
	</div>
	<div class="span5">
	<?php
	echo CHtml::ajaxLink('Import Remote Sheet',array('/importRoutine/importsheet'),array('update'=>'#drag-data2','data'=>array('id'=>$importRoutineModel2->id)),array('class'=>'btn btn-primary import-sheet','style'=>'margin-left:20px;margin-bottom:20px;'));
	?><br/>
		<iframe style=" width:500px;height:100px;" frameborder="0" src="<?php echo $this->createUrl('importRoutine/fetchColumn',array('id'=>$importRoutineModel2->id))?>">
		
	</iframe>
	</div>
</div>
<div class="row">
	<div class="span5">
	<div class="span2">
		<div id="droppable" class="ui-widget-header droppable" :field_name="MPN" :field="ImportRoutine_new_mfg_sku">
			<p>MPN</p>
		</div>
		<div id="droppable" class="ui-widget-header droppable" :field_name="Ware House 1" :field="ImportRoutine_ware_1">
		  <p>Qty (warehouse1)</p>
		</div>
		<div id="droppable" class="ui-widget-header droppable" :field_name="Price" :field="ImportRoutine_price">
		  <p>Price</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="Mfg Name" :field="ImportRoutine_new_mfg_name">
		  <p>Mfg Name</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="Mfg Part Name" :field="ImportRoutine_new_mfg_part_name">
		  <p>Mfg Part Name</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="UPC" :field="ImportRoutine_new_upc">
		  <p>UPC</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="MAP" :field="ImportRoutine_min_adv_price">
		  <p>MAP</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="Sup SKU" :field="ImportRoutine_new_sup_sku">
		  <p>Sup SKU</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="Sup SKU Name" :field="ImportRoutine_new_sup_sku_name">
		  <p>Sup SKU Name</p>
		</div>
		
		<div id="droppable" class="ui-widget-header droppable" :field_name="Sup Description" :field="ImportRoutine_new_sup_description">
		  <p>Sup Description</p>
		</div>
	</div>
	
	<div class="span2">
		<div class="span2" id="drag-data"> 
		<?php
		
		if(!empty($column)){
		?>
		
		<?php
			foreach($column as $id=>$field){

			?>	
				<div class="ui-widget-content draggable" :sheet_field="<?php echo $field?>" :sheet_num="<?php echo $id+1?>"><?php echo $id+1?> - <?php echo $field?></div>
			
			<?php	
			}
			?>
		
			
		<?php
		}
		?>
		</div>
	</div>
	</div>
	<div class="span5">
	<div class="span2">
		<div id="droppable" class="ui-widget-header droppable" :field_name="MPN" :field="ImportRoutine2_new_mfg_sku">
			<p>MAP to Sheet 1</p>
		</div>
		<div id="droppable" class="ui-widget-header droppable" :field_name="Price" :field="ImportRoutine2_price">
		  <p>Price</p>
		</div>
		<div id="droppable" class="ui-widget-header droppable" :field_name="MAP" :field="ImportRoutine2_min_adv_price">
		  <p>MAP</p>
		</div>
	</div>
	
	<div class="span2">
		<div class="span2" id="drag-data2"> 
		<?php
		
		if(!empty($column2)){
		?>
		
		<?php
			foreach($column2 as $id=>$field){

			?>	
				<div class="ui-widget-content draggable" :sheet_field="<?php echo $field?>" :sheet_num="<?php echo $id+1?>"><?php echo $id+1?> - <?php echo $field?></div>
			
			<?php	
			}
			?>
		
			
		<?php
		}
		?>
		</div>
	</div>
	</div>
</div>

<?php
/*
?>
    <link href="fineuploader-3.2.css" rel="stylesheet">

    <div id="fine-uploader"></div>
 
     <script src="/js/file-uploader.js"></script>
    <script>
      function createUploader() {
        var uploader = new qq.FineUploader({
          element: document.getElementById('fine-uploader'),
          request: {
            endpoint: 'server/handleUploads'
          }
        });
      }
      
      window.onload = createUploader;
    </script>
<!--
<iframe style="margin-top:0px; height:760px;" class="span10" frameborder="0" src="<?php echo $this->createUrl('importRoutine/fetchColumn',array('id'=>$importRoutineModel->id))?>">
</iframe>
-->
<?php
*/
?>
