<h1>Setup New SupWarehouse</h1><hr/><br/>


	
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse1','ware[1][1]')?>
		name:<?php echo CHtml::textField('ware[1][1]',$warehouseModel->wizardMultiWarehouse[1][1]);?>
		state:<?php echo CHtml::textField('ware[1][2]',$warehouseModel->wizardMultiWarehouse[1][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse2','ware[2][1]')?>
		name:<?php echo CHtml::textField('ware[2][1]',$warehouseModel->wizardMultiWarehouse[2][1]);?>
		state:<?php echo CHtml::textField('ware[2][2]',$warehouseModel->wizardMultiWarehouse[2][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse3','ware[3][1]')?>
		name:<?php echo CHtml::textField('ware[3][1]',$warehouseModel->wizardMultiWarehouse[3][1]);?>
		state:<?php echo CHtml::textField('ware[3][2]',$warehouseModel->wizardMultiWarehouse[3][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse4','ware[4][1]')?>
		name:<?php echo CHtml::textField('ware[4][1]',$warehouseModel->wizardMultiWarehouse[4][1]);?>
		state:<?php echo CHtml::textField('ware[4][2]',$warehouseModel->wizardMultiWarehouse[4][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse5','ware[5][1]')?>
		name:<?php echo CHtml::textField('ware[5][1]',$warehouseModel->wizardMultiWarehouse[5][1]);?>
		state:<?php echo CHtml::textField('ware[5][2]',$warehouseModel->wizardMultiWarehouse[5][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse6','ware[6][1]')?>
		name:<?php echo CHtml::textField('ware[6][1]',$warehouseModel->wizardMultiWarehouse[6][1]);?>
		state:<?php echo CHtml::textField('ware[6][2]',$warehouseModel->wizardMultiWarehouse[6][2]);?>
	</div>
	<div class="row">
	<?php echo CHtml::submitButton('supwarehouseSave'); ?>
	</div>



