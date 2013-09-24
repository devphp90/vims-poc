<?php

$this->breadcrumbs=array(

	'Supplier Overrides'=>array('index'),

	'Manage',

);



$this->menu=array(

	array('label'=>'Create','url'=>array('create')),
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

	$.fn.yiiGridView.update('import-sup-override-grid', {

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


<h1>User OverRides of Supplier Price</h1>


<style>
th a
{
	text-align: right;
}
.table td
{
	text-align: right;
}
</style>


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

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'import-sup-override-grid',

	'dataProvider'=>$model->search(),

	'filter'=>$model,

	'fixedHeader' => true,

	'headerOffset' => 61,
	'summaryText'=>'',
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

			'name'=>'comment',
			'htmlOptions' => array('style' => 'width: 200px; text-align: right'),

		),
		array(

			'name' => 'start',

			'htmlOptions' => array('style' => 'width: 120px; text-align: right'),


            'class'=>'bootstrap.widgets.TbJEditableColumn',
			'value'=>'substr($data->start,0,10)',
            'jEditableOptions' => array(

	            'type' => 'text',

				// very important to get the attribute to update on the server!

	            'submitdata' => array('attribute'=>'start'),

	            'cssclass' => 'form',


            )

		),

		array(

			'name' => 'end',

			'htmlOptions' => array('style' => 'width: 120px; text-align: right'),


			'value'=>'substr($data->end,0,10)',
            'class'=>'bootstrap.widgets.TbJEditableColumn',

            'jEditableOptions' => array(

	            'type' => 'text',

				// very important to get the attribute to update on the server!

	            'submitdata' => array('attribute'=>'end'),

	            'cssclass' => 'form',


            )

		),
		'applies_to_all',




		array(

			'name' => 'from',


            'class'=>'bootstrap.widgets.TbJEditableColumn',

            'jEditableOptions' => array(

	            'type' => 'text',

				// very important to get the attribute to update on the server!

	            'submitdata' => array('attribute'=>'from'),

	            'cssclass' => 'form',


            )

		),

		array(

			'name' => 'to',

            'class'=>'bootstrap.widgets.TbJEditableColumn',

            'jEditableOptions' => array(

	            'type' => 'text',

				// very important to get the attribute to update on the server!

	            'submitdata' => array('attribute'=>'to'),

	            'cssclass' => 'form',


            )

		),
		'applies_to_group',
		'applies_to_one_item',
		'percent_adjust',
		'dollar_adjust',
		'dollar_fixed',


		array(

			'name'=>'sup_id',


		),

		array(

			'name'=>'id',


		),

		array(

			'class'=>'bootstrap.widgets.TbButtonColumn',

			'htmlOptions' => array('style' => 'width: 150px;'),

			'headerHtmlOptions' => array('style' => 'width: 150px;'),

		),

	),

)); ?>

