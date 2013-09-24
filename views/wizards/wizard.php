

<h1>New Supplier Setup - <?php echo $supplierModel->name?></h1>
<?php
$this->breadcrumbs=array(
	'Sup Setup'=>array('index'),
	'Manage',
);
if(!empty($message)){
	Yii::app()->user->setFlash('success', $message);
	$this->widget('bootstrap.widgets.TbAlert', array(
	    'block'=>true, // display a larger alert block?
	    'fade'=>true, // use transitions?
	    'closeText'=>'×', // close link text - if set to false, no close link is displayed
	    'alerts'=>array( // configurations per alert type
		    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
	    ),
	));
}
?>
<br/>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="form">	

<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(

'Supplier'=>
        	$this->renderPartial(
        		'wizards/_supplier',compact('supplierModel','form'),1),
        		
        '<font color="'.(($supplierModel->isNewRecord?'red':'')).'">SupWarehouse</font>'=>
        	$supplierModel->isNewRecord?'':$this->renderPartial(
        		'wizards/_supwarehouse',compact('warehouseModel','form'),1),
        		
        '<font color="'.($supplierModel->isNewRecord?'red':'').'">ImportRoutine</font>'=>
        	$supplierModel->isNewRecord?'':$this->renderPartial(
        		'wizards/_importroutine',compact('importroutineModel','form'),1),
        		
        '<font color="'.($supplierModel->isNewRecord?'red':'').'">Map Item</font>'=>
        	$supplierModel->isNewRecord?'':$this->renderPartial(
        		'wizards/_importroutine_mapitem',compact('importroutineModel','form'),1),
        	
       '<font color="'.(!$supplierModel->isNewRecord && SupWarehouse::model()->count('sup_id=?',array($supplierModel->id))>0?'':'red').'">Map QOH</font>'=>
       		(!$supplierModel->isNewRecord && SupWarehouse::model()->count('sup_id=?',array($supplierModel->id))>0)?'':'red'?'':$this->renderPartial(
       			'wizards/_importroutine_mapqoh',compact('importroutineModel','supplierModel','form'),1),
       		
        '<font color="'.($supplierModel->isNewRecord?'red':'').'">Match</font>'=>
        	$supplierModel->isNewRecord?'':$this->renderPartial(
        		'wizards/_importroutine_match',compact('importroutineModel','form'),1),
        		
        '<font color="'.($importroutineModel->isNewRecord?'red':'').'">Fetch</font>'=>
        	$importroutineModel->isNewRecord?'':$this->renderPartial('wizards/_fetch',compact('importroutineModel'),1),

        	
    ),
    // additional javascript options for the tabs plugin

));
?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Create' : 'Save'));?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php $this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Cancel',
	'htmlOptions'=>array(
		'onclick'=>'js:location.href="../admin";',
	),
));?>	
</div><!-- form -->

<?php $this->endWidget(); ?>
