<?php
$this->breadcrumbs=array(
	'Supplier Setup'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create','url'=>array('create')),
	array('label'=>'Manage','url'=>array('admin')),
	array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
  array('label'=>'Run I/U','url'=>array('importRoutine/triggleIU', 'id' => $model->id)),
);
?>

<h1>Supplier Setup - <?php echo $supplierModel->name?></h1>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>


	<div class="modal-body">
		Be sure to review, "What row does data start with?"<br/>
		Remember to click, Save in Sheet Info tab.
	</div>

	<div class="modal-footer">


		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_tabform',compact('model','supplierModel','importRoutineModel','importRoutineModel2','columns', 'navsup_model', 'emailTabOnly')); ?>