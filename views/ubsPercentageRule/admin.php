<?php
/* @var $this UbsPercentageRuleController */
/* @var $model UbsPercentageRule */

$this->breadcrumbs=array(
	'Difference In Cost Percentage Rule'=>array('index'),
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
	$.fn.yiiGridView.update('ubs-percentage-rule-grid', {
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

<h1>Manage Difference In Cost Percentage Rule</h1>


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
<br/><br/>
<form id="frm-apply-width" class="form-inline" method="POST">
  <select name="column_field" >
    <option value="0">Select column ...</option>
    <option value="start_price">Start Price</option>
    <option value="end_price">End Price</option>
  </select>
  <input type="text" name="column_width" value="" />
  <button id="btn-apply-width" class="btn">Apply</button>
</form>

<script type="text/javascript">
  $('#frm-apply-width').bind('submit', function(){
    var column_field = $('select', this).val();
    var column_width = $('input', this).val();

    console.log(column_field, column_width);

    if (column_field == 0 || column_width == 0)
     return false;

    $('#col-' + column_field).css('width', column_width);

    return false;
  });
</script>
<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'ubs-percentage-rule-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
  'summaryText' => '',
	'columns'=>array(
    array(
      //'header'=>'Status',
      'name'=>'status',
      'type'=>'raw',
      'headerHtmlOptions' => array('style' => 'width: 150px;'),
      'value'=>'CHtml::ajaxLink($data->status?"On":"Off", array("statusToggle", "id"=>$data->id), array(
				"success"=>\'function(res){$(".status_\'.$data->id.\'").html(res)}\',

			),array(
				"class"=>"status_".$data->id,
				"id" => "toggle_".$data->id,

			));',
    ),
		array(
      'id' => 'col-start_price',
			'name' => 'start_price',
			'htmlOptions' => array('style' => 'width: 150px; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 150px; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'start_price'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
      'id' => 'col-end_price',
			'name' => 'end_price',
			'htmlOptions' => array('style' => 'width: 150px; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 150px; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'end_price'),
	            'cssclass' => 'form',
	            'width' => '80px'
            )
		),
		array(
			'name'=>'percent',
			'value'=>'$data->percent."%"',
			'htmlOptions' => array('style' => 'width: 150px; text-align: right'),
			'headerHtmlOptions' => array('style' => 'width: 150px; text-align: right'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'jEditableOptions' => array(
	            'type' => 'text',
				// very important to get the attribute to update on the server!
	            'submitdata' => array('attribute'=>'percent'),
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
