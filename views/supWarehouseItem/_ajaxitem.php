
<?php
$this->breadcrumbs=array(
	'Sup Warehouse Items'=>array('index'),
	'Manage',
);

$this->menu=array(
);

?>
<div class="well">
<h4>Warehouse Detail</h4>
<?php
echo CHtml::link('Create Item',array('/supWarehouseItem/create','id'=>$id),array('target'=>'_blank'));
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sup-warehouse-item-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(

		'ware_id',
		'warehouse.name',
		'qty_on_hand',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
</div>