<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<style>
.draggable { width: 100px; height: 20px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
#droppable { width: 150px; height: 50px; padding: 0.5em; float: left; margin: 10px; }
</style>
<script>
  $(function() {
    $( ".droppable" ).droppable({
    	hoverClass: "ui-state-active",
    	drop: function( event, ui ) {
	    	$(this).addClass( "ui-state-highlight" ).find( "p" ).html( $(this).attr(":field_name") + " Matched! - " + ui.draggable.attr(':sheet_field'));
	    	console.log('123');
	    	$('#' + $(this).attr(":field")).val(ui.draggable.attr(':sheet_num'));
	    	
			console.log('#' + $(this).attr(":field"));
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

	      	//$('#' + $(this).attr(":field")).val('');
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
	<div class="span12">
	
		<?php
	echo CHtml::ajaxLink('Display Supplier Sheet',array('/importRoutine/getPartialSheet'),array('update'=>'#preview-data','data'=>array('id'=>$importRoutineModel->id),'beforeSend'=>'function(){$(".progress_1").show();}'),array('class'=>'btn btn-primary import-sheet','style'=>'margin-left:20px;margin-bottom:20px;'));
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Drag sSheet column header to vSheet box.';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last sSheet Retrieve Time:';
	echo $importRoutineModel->getImportModel()->last_import_time;
	?>
	</div>
</div>
<div class="row" style="position:fixed;left:150px;top:300px;">
<div class="span16">
		<div id="droppable" style="width:110px;height:80px;" class="span2 ui-widget-header droppable" :field_name="MPN" :field="ImportRoutine_new_mfg_sku">
			<p>MPN</p>
		</div>
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="QTY" :field="ImportRoutine_ware_1">
		  <p>Qty</p>
		</div>
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Price" :field="ImportRoutine_price">
		  <p>Price</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Mfg Name" :field="ImportRoutine_new_mfg_name">
		  <p>Mfg Name</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Mfg Part Name" :field="ImportRoutine_new_mfg_part_name">
		  <p>Mfg Part Name</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="UPC" :field="ImportRoutine_new_upc">
		  <p>UPC</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="MAP" :field="ImportRoutine_min_adv_price">
		  <p>MAP</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Supp SKU" :field="ImportRoutine_new_sup_sku">
		  <p>Supp SKU</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Supp SKU Name" :field="ImportRoutine_new_sup_sku_name">
		  <p>Supp SKU Name</p>
		</div>
		
		<div id="droppable" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Supp Description" :field="ImportRoutine_new_sup_description">
		  <p>Supp Descrip</p>
		</div>
	</div></div>
<div style="height:100px;"></div>
<div id="preview-data" style="display:block;">


</div>
