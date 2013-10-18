<?php
$this->breadcrumbs = array(
    'Ubs Suppliers' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List ', 'url' => array('index')),
    array('label' => 'Create ', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ubs-supplier-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ubs Suppliers</h1>

<div class="search-form" style="display:none">
    <?php //$this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'ubs-supplier-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'SupplierID',
        'SupplierName',
        'Address1',
        'Address2',
        'City',
        'State',
        'Zip',
        'Country',
        'Email',
        'Fax',
        'Phone',
        'TollFreePhone',
        'MainContact',
        'MainContactPhone',
        'Phone_2',
        //'TimeStamp',
        'Phone2',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
