<?php
$this->breadcrumbs=array(

	'Ubs Items Syncs'=>array('index'),

	'Manage',

);


$this->menu=array(

	array(

		'label'=>'Search',

		'url'=>'#',

		'linkOptions'=>array(

			'class'=>'search-button',

		),

	),

	array(

		'label'=>'Create',
		'url'=>array('create'),

	),

    array('label'=>'Import CSV file','url'=>array('importCSV')),

    array('label'=>'Delete All','url'=>array('deleteAll')),

    array('label'=>'Update/Sync VIMS UBS Items Table','url'=>array('sync')),

);




Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('ubs-items-sync-grid', {

		data: $(this).serialize()

	});

	return false;

});

");

?>



<h1>UBS Items Seed Routine</h1>





<div class="search-form" style="display:none">

<?php $this->renderPartial('_search',array(

	'model'=>$model,

)); ?>
</div><!-- search-form -->



<?php $this->widget('bootstrap.widgets.TbGridView',array(

	'id'=>'ubs-items-sync-grid',

	'dataProvider'=>$model->search(),

	'filter'=>$model,

	'columns'=>array(
		'sku',
		'name',
		'manufacturer',
		'manufacturer_part_number',
		'upc',
        'sale_price',
		'our_cost',
		'created_time',
        array('header' => 'ID',
            'value' => '$data->id'
        ),

		array(

			'class'=>'bootstrap.widgets.TbButtonColumn',

		),

	),

)); ?>

