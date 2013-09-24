

<?php
		
		if(!empty($column)){

	foreach($column as $id=>$field){

	?>	
		<div class="ui-widget-content draggable" :sheet_field="<?php echo $field?>" :sheet_num="<?php echo $id+1?>"><?php echo $id+1?> - <?php echo $field?></div>
	
	<?php	
	}
	}
	?>
	
	
	<script>
  $(function() {


    $( ".draggable" ).draggable();
  });
  </script>