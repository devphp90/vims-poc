<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>jQuery UI Droppable - Default functionality</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" />
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
  <style>
  #draggable { width: 100px; height: 20px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
  #droppable { width: 150px; height: 50px; padding: 0.5em; float: left; margin: 10px; }
  </style>
  <script>
  $(function() {
//  	$('#ImportRoutine_new_mfg_sku').val('123');
  	$("#ImportRoutine_new_mfg_sku").attr('value','123')
    $( ".draggable" ).draggable();
    $( ".droppable" ).droppable({
    	hoverClass: "ui-state-active",
    	drop: function( event, ui ) {
	    	$(this).addClass( "ui-state-highlight" ).find( "p" ).html( $(this).attr(":field") + " Matched! - " + ui.draggable.attr(':sheet_field'));
	    	console.log(ui.draggable.attr(':sheet_field') + " - " + ui.draggable.attr(':sheet_num'));
	    	console.log($(this).attr(':field'));
	    	//$('#' + $(this).attr(':field')).val(ui.draggable.attr(':sheet_num'));
	    	$('#ImportRoutine_new_mfg_sku').val('123');

	    },
	    out: function( event, ui){
	      	$(this).removeClass( "ui-state-highlight" ).find( "p" ).html( $(this).attr(":field") );

	      	$(this).droppable("enable");
	    }
    });
  });
  </script>
</head>
<body>


</body>
</html>
<?php
//exit;
?>
<div class="span10">
	<?php
	?>
</div>
<div class="span10">


<?php

	echo CHtml::beginForm(array('/importRoutine/fetchColumn/'.$model->id),'post',array(
		'enctype'=>'multipart/form-data',
		));
	echo CHtml::fileField('file','',array(

		));

	echo CHtml::submitButton('Import Local Sheet',array('class'=>'btn btn-primary'));


echo CHtml::endForm();	

?>
</div>
