<?php

$this->breadcrumbs = array(

    'Sup Items Syncs' => array('index'),

    'Manage',

);



$this->menu = array(

    array('label' => 'Create ', 'url' => array('create')),

    array('label' => 'Import CSV', 'url' => array('import')),

    array('label' => 'Delete All', 'url' => array('deleteAll')),

	array('label' => 'Update/sync Supp Items', 'url' => array('sync')),



);



Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('sup-items-sync-grid', {

		data: $(this).serialize()

	});

	return false;

});

");

?>



<h1>Supplier Items Seed Routine</h1>


<div class="row offset1">
	<form action="/supItemsSync/customSync" method="get" accept-charset="utf-8">
		

	<div class="row">
		<label for="ubs_sup_id">UBS Supplier Id (ubs_supplier_item_seed)</label>
		<input id="ubs_sup_id" type="text" name="ubs_sup_id" value="">
	</div>
	<div class="row">
		<label for="vims_sup_id">VIMS Supplier Id (vims_sup_inventory)</label>
		<input id="vims_sup_id" type="text" name="vims_sup_id" value="">
	</div>
	<div class="row">
		<label for="column_1">Sup vSKU column</label>
		<input id="column_1" type="text" name="column_1" class="span1" value=""> + 
		<input id="column_2" type="text" name="column_2" class="span1" value=""> +
		<input id="column_3" type="text" name="column_3" class="span1" value="">
	</div>	
	<div class="row">
		<input type="submit" class="btn">
	</div>
	</form>
</div>

<div class="search-form" style="display:none">

    <?php $this->renderPartial('_search', array(

    'model' => $model,

)); ?>

</div><!-- search-form -->



<?php $this->widget('bootstrap.widgets.TbGridView', array(

    'id' => 'sup-items-sync-grid',

    'dataProvider' => $model->search(),

    'filter' => $model,

    'columns' => array(

        'id',

        'UbsSupplierName',

        'UbsSupplierID',

        'UbsSku',

        'Mpn',

        'Upc',

        'SupplierSku',

        'ItemName',

        'sup_id',

        'sup_vsku',

        array(

            'class' => 'bootstrap.widgets.TbButtonColumn',

        ),

    ),

)); ?>

