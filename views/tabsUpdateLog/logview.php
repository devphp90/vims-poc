<?php

$this->breadcrumbs=array(

	'Tabs Update Logs'=>array('index'),

	'Manage',

);

$this->menu=array(
	array('label'=>'Clear Update log', 'url'=>array('supdelall','id'=>$tabs_id)),
	array('label'=>'Reset Update log', 'url'=>array('supreset','id'=>$tabs_id)),
);

?>



<h1>Update Log: <?php echo Tabs::model()->findByPk($tabs_id)->supplier->name?></h1>



<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'tabs-import-log-grid',
	'dataProvider'=>$model->supsearch($tabs_id),
	'fixedHeader' => true,
	'headerOffset' => 61,
	'columns'=>array(

		array(

			'name'=>'create_time',

			'header'=>'Update Start',

			'sortable'=>false,
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),

		),

		array(

			'name'=>'finish_time',

			'header'=>'Update Finish',

			'type'=>'raw',

			'value'=>'$data->finish_time."<br/>".($data->finish_time!="0000-00-00 00:00:00"?(strtotime($data->finish_time)-strtotime($data->create_time)):"0")." Secs"',

			'sortable'=>false,
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),

		),

		array(

			'header'=>'Sheet Changes <br/>Qty and/or Price<br/>PASS/FAIL <a href="#" rel="tooltip" title="A sheet could FAIL if a % of Items change QTY and/or Price. If Rule=50%, and 51% of Items had a Price change from last Update, then FAIL. If 25% had a QTY change AND 26% had a Price change, then FAIL." style="display:inline;">(?)</a>',

			'name'=>'data_integrity_status',

			'type'=>'raw',

			'value'=>'$data->_status[$data->data_integrity_status]."<br/>".$data->data_integrity_reason',

			'sortable'=>false,
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),

		),

		array(

			'header'=>'Sheet Changes <br/>Items InStock<br/>PASS/Fail <a href="#" rel="tooltip" title="FAIL if % of Items change stock status.  If Rule=20%, and 30% go from InStock to BO, then FAIL. Buffer rules apply to determine stock status." style="display:inline;">(?)</a>',

			'name'=>'instock_item_status',

			'type'=>'raw',

			'value'=>'$data->_status[$data->instock_item_status]."<br/>".$data->instock_item_reason',

			'sortable'=>false,
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),

		),

		array(

			'header'=>'Single Item Changes<br/>Qty<br/>WARNING <a href="#" rel="tooltip" title="If any Item QTY changes by more than Rule %, then WARN." style="display:inline;">(?)</a>',

			'name'=>'qoh_percent_change_status',

			'type'=>'raw',

			'value'=>'$data->_status[$data->qoh_percent_change_status]."<br/>".$data->qoh_percent_change_reason',

			'sortable'=>false,
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),

		),

		array(

			'header'=>'Single Item Changes<br/>Price<br/>WARNING <a href="#" rel="tooltip" title="If any Item PRICE changes by more than Rule %, then WARN." style="display:inline;">(?)</a>',

			'name'=>'price_percent_change_status',

			'type'=>'raw',

			'value'=>'$data->_status[$data->price_percent_change_status]."<br/>".$data->price_percent_change_reason',

			'sortable'=>false,
			'htmlOptions' => array('style' => 'width: 7%;'),
			'headerHtmlOptions' => array('style' => 'width: 7%'),

		),
		array(

			'header'=>'vSheet<br/>Update<br/>Progress<a href="#" rel="tooltip" title="test">(?)</a>',

			'name'=>'finish_item',

			'sortable'=>false,

		),
		array(

			'header'=>'vSheet<br/>Items',

			'name'=>'vsheet_item',

			'sortable'=>false,

		),
		
		array(

			'header'=>'Found in<br/>Supplier items<br/>and Updated',

			'name'=>'instock_item',

			'sortable'=>false,

		),
		array(

			'header'=>'New Items<br/>Added To<br/>Checkers',

			'name'=>'checker_item',

			'sortable'=>false,

		),
		array(

			'header'=>'New Items<br/>in Checkers<br/>from Previous<br/>Update',

			'name'=>'already_checker_item',

			'sortable'=>false,

		),

		array(

			'header'=>'Drop Item #',
			'type'=>'raw',
			'name'=>'drop_item',

			'sortable'=>false,

		),
		array(

			'header'=>'Drop Items',
			'type'=>'raw',
			'name'=>'drop_items',

			'sortable'=>false,

		),

		array(

			'name'=>'id',

			'sortable'=>false,

		),

		array(

			'header'=>'supplier Id',

			'name'=>'tab.supplier.id',

		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),

	),

)); ?>

