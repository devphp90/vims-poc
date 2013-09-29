<script>
function checker()
{
	var checks = '';
	$('.checker').each(function(){
		if($(this).attr("checked"))	
			checks += $(this).val() + ',';
	});
	
	
	$.ajax({
    	type: "GET",
    	url: "<?php echo $this->createUrl('/supNewItem/import')?>",
    	data: {
    		data: checks,
    	},
    	success: function(result) {
    		//alert('success');
    	},
    	error: function(jqXHR, textStatus, errorThrown) {

       		alert('');
     	},
    });
    
    
	$('input:radio').click(function(){
		
		$.ajax({
	    	type: "GET",
	
	    	url: "<?php echo $this->createUrl('/supNewItem/updateMatch')?>",
	
	    	data: {
	
	    		id: $(this).attr(":id"),
	    		value: $(this).attr("value")
	
	    	},
	
	    	success: function(result) {

	    	},
	
	    	error: function(jqXHR, textStatus, errorThrown) {
	
	     	},
	
	    });
	});
	
	
}
</script>
<?php
$this->breadcrumbs=array(
	'Sup New Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Search/Filter','url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sup-new-item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->helpText = 'Sample Text';

?>

<h1>Manage Supplier New Items</h1>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sup-new-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'import_id',
		array(
			'header'=>'Supplier',
			'name'=>'sup_id',
			'type'=>'raw',
			'headerHtmlOptions'=>array(
				'style'=>'background-color: #666666;',
			),
			'value'=>'$data->import_routine->supplier->name.\'<br/>\'.$data->import_routine->sup_id',
		),
		array(
			'name'=>'sup_vsku',
			'headerHtmlOptions'=>array(
				'style'=>'background-color: #666666;',
			),
		),
		array(
			'name'=>'sup_sku',
			'headerHtmlOptions'=>array(
				'style'=>'background-color: #666666;',
			),
		),
		array(
			'name'=>'sup_sku_name',
			'headerHtmlOptions'=>array(
				'style'=>'background-color: #666666;',
			),
		),
		array(
			'name'=>'sup_description',	
			'headerHtmlOptions'=>array(
				'style'=>'background-color: #666666;',
			),
		),
		


		
		'mfg_sku',
		'upc',
		'mfg_name',
		'mfg_part_name',
		array(
			'type'=>'raw',
			'header'=>'Mannual<br/>Accept',
			'value'=>'CHtml::link("Accept",array("/supInventory/create","new_id"=>$data->id),array("target"=>"_blank"))',
		),
		array(
			'name'=>'item_status',
			'value'=>'$data->statusList[$data->item_status]',
		),

/*
		
		array(
			'type'=>'raw',
			'value'=>'CHtml::ajaxLink("Accept",array("/supNewItem/updateStatus","id"=>$data->id,"value"=>1),array("success"=>"function(){ $.fn.yiiGridView.update(\'sup-new-item-grid\');}"))',
		),
		
*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
