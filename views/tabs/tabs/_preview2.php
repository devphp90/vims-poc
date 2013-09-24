<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<style>
.draggable { width: 100px; height: 20px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
#droppable2 { width: 150px; height: 50px; padding: 0.5em; float: left; margin: 10px; }
</style>
<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$column = unserialize(base64_decode($importRoutineModel->fetch_column));
$column2 = unserialize(base64_decode($importRoutineModel2->fetch_column));
?>
<div class="row">
	<div class="span12">
	
		<?php
	echo CHtml::ajaxLink('Display Supplier Sheet',array('/importRoutine/getPartialSheet'),array('update'=>'#preview-data2','data'=>array('id'=>$importRoutineModel2->id),'beforeSend'=>'function(){$(".progress_1").show();}'),array('class'=>'btn btn-primary import-sheet','style'=>'margin-left:20px;margin-bottom:20px;'));
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Drag sSheet column header to vSheet box.';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last sSheet Retrieve Time:';
	echo $importRoutineModel2->getImportModel()->last_import_time;
	?>
	</div>
</div>
<div class="row" style="position:fixed;left:150px;top:300px;">
<div class="span16">
		<div id="droppable2" style="width:110px;height:80px;" class="span2 ui-widget-header droppable" :field_name="MPN" :field="ImportRoutine2_new_mfg_sku">
			<p>MPN</p>
		</div>
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="QTY" :field="ImportRoutine2_ware_1">
		  <p>Qty</p>
		</div>
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Price" :field="ImportRoutine2_price">
		  <p>Price</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Mfg Name" :field="ImportRoutine2_new_mfg_name">
		  <p>Mfg Name</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Mfg Part Name" :field="ImportRoutine2_new_mfg_part_name">
		  <p>Mfg Part Name</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="UPC" :field="ImportRoutine2_new_upc">
		  <p>UPC</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="MAP" :field="ImportRoutine2_min_adv_price">
		  <p>MAP</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Supp SKU" :field="ImportRoutine2_new_sup_sku">
		  <p>Supp SKU</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Supp SKU Name" :field="ImportRoutine2_new_sup_sku_name">
		  <p>Supp SKU Name</p>
		</div>
		
		<div id="droppable2" style="width:110px;height:80px;" class="ui-widget-header droppable" :field_name="Supp Description" :field="ImportRoutine2_new_sup_description">
		  <p>Supp Descrip</p>
		</div>
	</div></div>
<div style="height:100px;"></div>
<div id="preview-data2" style="display:block;">


</div>
