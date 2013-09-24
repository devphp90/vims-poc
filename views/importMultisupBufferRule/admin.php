<?php
/* @var $this ImportMultisupBufferRuleController */
/* @var $model ImportMultisupBufferRule */

$this->breadcrumbs=array(
	'Import Multisup Buffer Rules'=>array('index'),
	'Manage',

);

$this->menu=array(
//	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
//	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
    array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-multisup-buffer-rule-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>


	<div class="modal-body">
		Text here....
	</div>

	<div class="modal-footer">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'type'=>'primary',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>

<h1>Multi-Supplier Buffer Rules</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbButtonGroup', array(
  'size'=>'small',
  'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
  'buttons'=>array(
    array('label'=>'On/Off', 'items'=>array(
      array('label'=>'Switch all to ON', 'url'=>'?status=ON'),
      array('label'=>'Switch all to OFF', 'url'=>'?status=OFF'),
    )
    ),
  ),
));
?>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'import-multisup-buffer-rule-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'columns'=>array(
        array(
			//'header'=>'Status',
			'name'=>'status',
			'type'=>'raw',
			'value'=>'CHtml::ajaxLink($data->status?"On":"Off", array("statusToggle", "id"=>$data->id), array(
				"success"=>\'function(res){$(".status_\'.$data->id.\'").html(res)}\',

			),array(
				"class"=>"status_".$data->id,
				"id" => "toggle_".$data->id,

			));',
		),
		array(
			'name' => 'sup_qty',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'sup_qty'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name' => 'start_qty',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'start_qty'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name' => 'end_qty',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'end_qty'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name' => 'from',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'from'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name' => 'to',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'to'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name' => 'qty',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'qty'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
    array(
      'name'=>'id',
      'sortable'=>false,
      'htmlOptions' => array('style' => 'width: 5%;'),
      'headerHtmlOptions' => array('style' => 'width: 5%'),
    ),
    array(
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'htmlOptions' => array('style' => 'width: 150px;'),
      'headerHtmlOptions' => array('style' => 'width: 150px;'),
    ),
	),
)); ?>
