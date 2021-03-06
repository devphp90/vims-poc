<?php
/* @var $this ImportSupMarkupController */
/* @var $model ImportSupMarkup */

$this->breadcrumbs=array(
	'Import Sup Markups'=>array('index'),
	'Manage',
);

$this->menu=array(
	// array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	// array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
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
	$.fn.yiiGridView.update('import-sup-markup-grid', {
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

<h1>Supplier Level Price Markup and Break MAP Rules</h1>


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
	'id'=>'import-sup-markup-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
	'summaryText' => '',
	'columns'=>array(


		array(

			'name'=>'supplier_name',
			'type'=>'raw',

			'value'=>'(isset($data->supplier)?$data->supplier->name:\'\')',

			'htmlOptions' => array('style' => 'width: 15%;'),
			'headerHtmlOptions' => array('style' => 'width: 15%'),
		),
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
			'name' => 'markup',
			'htmlOptions' => array('style' => 'width: 15%; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 15%; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'markup'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name'=>'type',
			'value'=>'$data->type?"%":"$"',
			'htmlOptions' => array('style' => 'width: 10%;'),
			'headerHtmlOptions' => array('style' => 'width: 10%'),
		),
		array(
			'name'=>'break_map',
			'value'=>'$data->break_map?"Yes":"No"',
		),
		/*

		'create_time',
		'update_time',
		'create_by',
		'update_by',
		*/
		'sup_id',
		'id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' => 'width: 150px;'),
			'headerHtmlOptions' => array('style' => 'width: 150px;'),
		),
	),
)); ?>
