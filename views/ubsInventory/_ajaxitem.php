

<div class="well">
<h4>Supplier Detail</h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sup-warehouse-item-grid',
	'dataProvider'=>$dataProvider,
	'summaryText'=>'',
	'columns'=>array(

		array(
			'name'=>'sup_id',
			'type'=>'raw',
			'value'=>'CHtml::link($data->supplier->name,array(\'/Supplier/view\',\'id\'=>$data->sup_id),array(\'target\'=>\'_blank\'))',
		),
		
		'sup_vsku',
		array(
			'header'=>'Stock Status',
			'name'=>'sup_status',
			'value'=>'SupInventory::$statusToStringMap[$data->sup_status]',
		),
		array(
			'name'=>'supplier.cancelRate',
		),
		array(
			'header'=>'Location',
			'value'=>'$data->warehouse1->state.", ".$data->warehouse1->item->qty_on_hand',
		),
		'uprice',
		'sup_price',
		
		
		'qty_total',
		'sup_vqoh',
		
		array(
			'header'=>'Supplier ID',
			'name'=>'sup_id',
		),
		'id',

	),
)); 

?>
</div>
