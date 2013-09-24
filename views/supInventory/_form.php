
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tabs-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
	<?php echo $form->errorSummary($model); ?>
	
	<?php

	$this->widget('bootstrap.widgets.TbWizard', array(
		'type'=>'pills', // 'tabs' or 'pills'
		'encodeLabel'=>false,
	    'tabs'=>array(
	
	    	array(
	    		'id'=>'tabs_0',
	    		'label'=>'General Info',
	    		'content'=>$this->renderPartial('tabs/_mainform',compact('model','form'),1),
	    		'active'=>1,
	    	),
	    	array(
	    		'id'=>'tabs_2',
	    		'label'=>'User OverRide Qty and Price',
	    		'content'=>$this->renderPartial('tabs/_defined',compact('model','form'),1),
	    	),
	    ),
	    'pagerContent' => '
		',
		'options' => array(
			'nextSelector' => '.button-next',
			'previousSelector' => '.button-previous',
			'onTabClick' => 'js:function(tab, navigation, index) {
				return true;
			}',
		),
	
    // additional javascript options for the tabs plugin

));
?>
<br/>
	

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

<div class="form">




</div><!-- form -->
<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScript('mytext', "jQuery('#SupInventory_supplier_name').autocomplete({'source':'/index.php/supplier/autocompleteSup'});");
?>