<div class="control-group ">
	<label class="control-label" for="sku_name">UBS SKU Name</label>
	<div class="controls">
		<?php
			echo CHtml::textField('sku_name',$model->sku_name,array('disabled'=>'true'));
		?>
	</div>
</div>	
<div class="control-group ">
	<label class="control-label" for="sku_name">UBS Description</label>
	<div class="controls">
		<?php
			echo CHtml::textArea('sku_description',$model->sku_description,array('disabled'=>'true'));
		?>
	</div>
</div>	