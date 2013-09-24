<h1>Setup New <?php echo $event->sender->getStepLabel($event->step)?> - <?php echo $_SESSION['Wizard.steps']['Supplier']['name']?></h1><hr/><br/>

<?php

echo $event->sender->menu->run();
echo '<br/>';
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sup-warehouse-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse1','ware[1][1]')?>
		name:<?php echo CHtml::textField('ware[1][1]',$_SESSION['Wizard.steps']['warehouse'][1][1]);?>
		state:<?php echo CHtml::textField('ware[1][2]',$_SESSION['Wizard.steps']['warehouse'][1][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse2','ware[2][1]')?>
		name:<?php echo CHtml::textField('ware[2][1]',$_SESSION['Wizard.steps']['warehouse'][2][1]);?>
		state:<?php echo CHtml::textField('ware[2][2]',$_SESSION['Wizard.steps']['warehouse'][2][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse3','ware[3][1]')?>
		name:<?php echo CHtml::textField('ware[3][1]',$_SESSION['Wizard.steps']['warehouse'][3][1]);?>
		state:<?php echo CHtml::textField('ware[3][2]',$_SESSION['Wizard.steps']['warehouse'][3][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse4','ware[4][1]')?>
		name:<?php echo CHtml::textField('ware[4][1]',$_SESSION['Wizard.steps']['warehouse'][4][1]);?>
		state:<?php echo CHtml::textField('ware[4][2]',$_SESSION['Wizard.steps']['warehouse'][4][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse5','ware[5][1]')?>
		name:<?php echo CHtml::textField('ware[5][1]',$_SESSION['Wizard.steps']['warehouse'][5][1]);?>
		state:<?php echo CHtml::textField('ware[5][2]',$_SESSION['Wizard.steps']['warehouse'][5][2]);?>
	</div>
	<div class="row" style="font-weight:bold;">
		<?php echo CHtml::label('Warehouse6','ware[6][1]')?>
		name:<?php echo CHtml::textField('ware[6][1]',$_SESSION['Wizard.steps']['warehouse'][6][1]);?>
		state:<?php echo CHtml::textField('ware[6][2]',$_SESSION['Wizard.steps']['warehouse'][6][2]);?>
	</div>

	<div class="row buttons">
		<?php  echo CHtml::submitButton('Next');  ?>
		<?php  echo CHtml::submitButton('Save & Exit');  ?>
	</div>

<?php $this->endWidget(); ?>


<?php


//echo CHtml::tag('div',array('class'=>'form'),$form);

?>


