<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui');?>
	
	
	
	
	
	

<div class="form span11">	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'import-routine4-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<?php


if($model->isNewRecord){
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs', // 'tabs' or 'pills'
		'encodeLabel'=>false,
		'tabs'=>array(
			array(
				'label'=>'Main <font color="green">*</font>', 
				'content'=>$this->renderPartial('_main',array('form'=>$form,'model'=>$model),1), 
				'active'=>true,
			),
		),
	));
	
}else{
	
    // additional javascript options for the tabs plugin
    $this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs', // 'tabs' or 'pills'
		'encodeLabel'=>false,
		'tabs'=>array(
			array(
				'label'=>'Main <font color="green">*</font>', 
				'content'=>$this->renderPartial('_main',array('form'=>$form,'model'=>$model),1), 
				'active'=>true,
			),
			array(
				'label'=>'Map Item <font color="green">*</font>', 
				'content'=>$this->renderPartial('_mapping',array('form'=>$form,'model'=>$model),1), 
			),
			array(
				'label'=>'Map QOH <font color="green">*</font>', 
				'content'=>$this->renderPartial('_warehouse',array('form'=>$form,'model'=>$model),1), 
			),
			array(
				'label'=>'Match <font color="green">*</font>', 
				'content'=>$this->renderPartial('_match',array('form'=>$form,'model'=>$model),1), 
			),
		),
	));

	
}
?>

	<div class="form-actions" >
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

</div><!-- form -->
<?php
if(!$model->isNewRecord){
?>
<div class="span2 offset2">
	<iframe style="margin-top:0px; height:760px;width:320px;float:right;" frameborder="0" src="<?php echo $this->createUrl('importRoutine/fetchColumn',array('id'=>$model->id))?>">
</iframe>
</div>
<?php
}
?>

