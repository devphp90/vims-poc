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

