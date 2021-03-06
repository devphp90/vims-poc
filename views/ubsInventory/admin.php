<?php
$this->breadcrumbs=array(
	'Ubs Inventory'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Import', 'url'=>array('manual')),
	array(
		'label'=>'Search', 
		'url'=>'#',
		'linkOptions'=>array(
			'class'=>'search-button',
		),
	),
	array(
		'label'=>'Help',
		'url'=>'#',
		'linkOptions'=>array(
			'data-toggle'=>'modal',
			'data-target'=>'#myModal',
		),
	),
	array(
		'label'=>'Record Count = '.$count,
		'url'=>'#',
		'linkOptions'=>array(
			'style'=>'color: black;',
		),
	),
	array(
		'label'=>'Global Cancel Rate Threshold: '. SystemInfo::model()->findByPk(1)->cancel_rate_limit,
		'url'=>'#',
		'linkOptions'=>array(
			'style'=>'color: black;',
		),
	),
	
);
$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => 'x',
    'htmlOptions' => array('style' => 'position: absolute; top:87px;width:600px;left:292px')
));
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-inventory-grid', {
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
		Sale Price = Markup Price, if BreakMap = Yes.
		Edit record and Save to re-calc values and write to DB.
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
<h1 style="display:inline;float:left;margin:0 0;">UBS Items</h1>
<div class="span4 offset3" style="">
	
</div>
<div style="clear:both;"></div>
<hr style="margin-top:0px; margin-bottom:0px;">
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'ubs-inventory-grid',
    'filter'=>$model,
	'fixedHeader' => true,
	'headerOffset' => 61,
    'type'=>'striped',
    'dataProvider' => $model->search(),
    'summaryText'=>'',
    'columns' => 
    array(
		array(
			'name'=>'sku',
			'type'=>'raw',
			'value'=>'CHtml::link($data->sku,array("update","id"=>$data->id))',
			'sortable'=>false,
		),
		array(
			'name'=>'sku_name',
			'type'=>'raw',
			'value'=>'(strlen($data->sku_name)>20)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->sku_name."\">".substr($data->sku_name,0,10)."...</a>":$data->sku_name',
			'sortable'=>false,
      'filter' => false,
		),
		array(
			'name'=>'mfg_title',
			'sortable'=>false,
      'filter' => false,
		),
		array(
			'name'=>'mfg_name',
			'sortable'=>false,
      'filter' => false,
		),
		array(
			'name'=>'upc',
			'sortable'=>false,
      'filter' => false,
		),

		array(
			'header'=>'Primary Supplier',
			'name'=>'primary_supplier',
			'type'=>'raw',
			'value'=>'CHtml::link($data->primary_supplier_name_c.\'<br/>\'.$data->primary_supplier_c,array(\'/Supplier/view\',\'id\'=>$data->primary_supplier_c),array(\'target\'=>\'_blank\'))',
      'filter' => false,

		),
		array(
			'header'=>'vQTY',
			'name'=>'primary_supplier_vqoh_c',
			'filter'=>false,
		),
		array(
			'name'=>'user_price',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
			'sortable'=>false,
		),
		array(
			'header'=>'Supp Price',
			'name'=>'primary_supplier_price_c',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
			'sortable'=>false,
		),
		array(
			'header'=>'sMarkup<br/>Break_Map',
			'type'=>'raw',
			'value'=>'$data->smarkup_c?($data->smarkup_c."<br/>".($data->smarkupbreak_c?\'Yes\':\'No\')):\'\'',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		array(
			'header'=>'gMarkup',
			'value'=>'$data->gmarkup_c',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		array(
			'header'=>'Apply Markup',
			'value'=>'$data->applymarkup_c',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		array(
			'header'=>'Sell<br/>Price<br/>after<br/>Markup',
			'value'=>'$data->markup_c+$data->vprice',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		array(
			'header'=>'MAP',
			'name'=>'primary_supplier_map_c',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
			'sortable'=>false,
		),
		array(
			'header'=>'Final<br/>Sell<br/>Price',
			'name'=>'mark_up_sale_price',
			'value'=>'$data->markupprice_c',
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'htmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
		),
		
		array(
			'header'=>'Average<br/>Cost',
			'name'=>'price_average_c',
			'htmlOptions'=>array(
				'style'=>'width: 10px;background-color:#DFF0D8',
			),
			'headerHtmlOptions'=>array(
				'style'=>'background-color:#DFF0D8',
			),
			'filter'=>false,
			'sortable'=>false,
		),
		
		
		array(
			'header'=>'Total<br/>Supps',
			'name'=>'total_sup_count_c',
			'filter'=>false,
		),
		array(
			'header'=>'Supps InStock',
			'name'=>'sup_count_c',
			'value'=>'$data->sup_count_c',
			'filter'=>false,
		),
		array(
			'header'=>'Supps Excluded by Price Diff',
			'name'=>'total_supplier_exclude_c',
			'filter'=>false,
		),
		array(
			'header'=>'mSupps',
			'value'=>'$data->sup_count_c-$data->total_supplier_exclude_c',
			'filter'=>false,
		),
		array(
			'header'=>'Total mQTY',
			'name'=>'total_qty_total_c',
      'filter' => false,
		),
		array(
            'class'=>'bootstrap.widgets.TbRelationalColumn',
            'header'=>'InStock Combined QTY',
            'name' => 'qoh',
			'url' => $this->createUrl('cqohrelation'),
            'value'=> '$data->cqoh_c',
            'filter'=>false,
			'sortable'=>false,
		),
		array(
			'header'=>'Excluded QTY by Price Diff',
			'name'=>'total_qoh_exclude_c',
			'filter'=>false,
		),
		array(
			'header'=>'mBuffer',
			'value'=>'$data->mbuffer_c',
			'filter'=>false,
		),
		array(
			'header'=>'Effective mQTY',
			'name'=>'mqoh_c',
			'value'=>'$data->mqoh_c',
			'filter'=>false,
			'sortable'=>false,
		),

		
		
		array(
			'header'=>'ID',
			'name'=>'id',
			'sortable'=>false,
			'htmlOptions'=>array(
				'style'=>'width: 100px;',
			),
      'filter' => false,
		),
		array(
			'header'=>'ReCalc',
			'type'=>'raw',
			'value'=>'CHtml::link("ReCalc",array("/ubsInventory/reload","id"=>$data->id),array("target"=>"_blank"))',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array(
				'style'=>'width: 100px;',
			),
		),
		
		
		
    ),
    

));
?>
<div id="data"></div>
