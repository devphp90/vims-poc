<?php
$this->breadcrumbs=array(
	'Sup Item Overrides'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-sup-item-override-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>User OverRide Supplier Qty, at Supplier Item Level</h1>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'import-sup-item-override-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
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
//    'applies_to_all',




//    array(
//
//      'name' => 'from',
//
//
//      'class'=>'bootstrap.widgets.TbJEditableColumn',
//
//      'jEditableOptions' => array(
//
//        'type' => 'text',
//
//        // very important to get the attribute to update on the server!
//
//        'submitdata' => array('attribute'=>'from'),
//
//        'cssclass' => 'form',
//
//
//      )
//
//    ),

//    array(
//
//      'name' => 'to',
//
//      'class'=>'bootstrap.widgets.TbJEditableColumn',
//
//      'jEditableOptions' => array(
//
//        'type' => 'text',
//
//        // very important to get the attribute to update on the server!
//
//        'submitdata' => array('attribute'=>'to'),
//
//        'cssclass' => 'form',
//
//
//      )

//    ),
//    'applies_to_group',
    'applies_to_one_item',
//    'percent_adjust',
//    'dollar_adjust',
//    'dollar_fixed',

    'qty',
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
