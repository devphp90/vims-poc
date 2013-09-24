<?php
$this->breadcrumbs=array(
	'Supplier Inventory'=>array('index'),
	'Manage',
); ?>
<div>
  <h1>Supplier Items Missing from vSheet</h1>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'ubs-inventory4-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText'=>'',
	'columns'=>array(
    'sup_vsku',
		array(
			'name'=>'ubs_sku',
		),
		'sup_price',
		'iBuffer',

		'sBuffer',

		'gBuffer',
		array(
			'header'=>'Apply Buffer',
			'value'=>'$data->getBuffer()',
		),
		array(
			'header'=>'sQOH<br/>Warehouse detail',
			'type'=>'raw',
			'value'=>'$data->qty_total.\' \'.CHtml::ajaxLink("detail",array("/supWarehouseItem/ajaxItem"),array("update" => "#data","data"=>array("id"=>"js:$(this).parents(\'tr\').children(\':first\').html()")))',
		),
		array(
			'name'=>'sup_bqoh',

		),
		array(
			'name'=>'sup_open_order',
		),
		array(
			'name'=>'sup_vqoh',

		),

		'sup_sku',
		'mfg_sku',
		array(
			'header'=>'Stock Status',
			'name'=>'sup_status',
			'value'=>'SupInventory::$statusToStringMap[$data->sup_status]',
		),
    array(
      'name'=>'sup_id',
      'type'=>'raw',
      'htmlOptions'=>array(
        'style'=>'width:10px',
      ),
//			'value'=>'(isset($data->supplier)?$data->supplier->name:\'\').\'<br/>\'.$data->sup_id',
      'value'=>'CHtml::link($data->supplier->name,array(\'/Supplier/view\',\'id\'=>$data->sup_id),array(\'target\'=>\'_blank\')).\'<br/>\'.$data->sup_id',
    ),
		'last_update',
    'id',
	),
)); ?>

<div id="data">
</div>
