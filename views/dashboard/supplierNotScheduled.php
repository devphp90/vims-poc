<?php
$this->breadcrumbs = array(
    'Suppliers' => array('index'),
    'Manage',
);

$this->menu = array(
    array(
        'label' => 'Show Suppliers not Updated in x Days',
        'url' => '#',
        'linkOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#accept',
        ),
    ),
        //array('label'=>'List', 'url'=>array('index')),
        //array('label'=>'Create', 'url'=>array('create')),
        //array('label'=>'Export pdf','url'=>array('pdf'),),
        //array('label'=>'Export excel','url'=>array('excel')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('supplier-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<style>
    .grid-view .summary {
        float: right;
        margin-bottom: 5px;
        position: absolute;
        right: 62px;
        text-align: right;
        top: 152px;
        width: 249px;
    }
</style>

<h1>Supplier Non-Scheduled List</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
//$this->renderPartial('_search',array(
//	'model'=>$model,
//)); 
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'supplier-grid',
    'dataProvider' => $model->searchNotScheduled(),
    'filter' => $model,
    'columns' => array(
        array('name' => 'name', 'type' => 'raw', 'value' => '$data->getNameView()'),
        array('name' => 'update_time', 'header' => 'Last Update'),
		array('name' => 'agoTime', 'header' => 'Time Since Last Update'),
        array('name' => 'setup_status', 'value' => '$data->setupStatusValues[$data->setup_status]'),
        array('header' => 'Frequency', 'value' => '$data->getImportRoutine1()->frequency'),
        array(
            'header' => 'Active/InActive',
            'type' => 'raw',
            'value' => 'CHtml::ajaxLink($data->active==1?"Active":"InActive",Yii::app()->controller->createUrl("/supplier/ajaxStatus",array("id"=>$data->id)),array(
				"success"=>\'function(res){$("#status_\'.$data->id.\'").html(res)}\',
			
			),array(
				"id"=>"status_".$data->id,
			
			));',
        ),
        array(
            'header' => 'VIMS<br/>Supp<br/>ID1',
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:100px'))
        ,
        array(
            'name' => 'tab.id',
            'header' => 'VIMS<br/>Supp<br/>ID2',
            'value' => '(!empty($data->tab) ? $data->tab->id : "")',
            'htmlOptions' => array('style' => 'width: 50px'),
            'headerHtmlOptions' => array('style' => 'width: 50px'),
        ),
        array(
            'name' => 'ubs_supplier_id',
            'header' => 'UBS<br/>Supp<br/>ID',
        ),
    ),
));
?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'accept')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h4>Show Suppliers not Updated in x Days</h4>
</div>


<div class="modal-body">
    <form type="get">
        <div class="control-group">
            <label class="control-label">Number of Days</label>
            <div class="controls">
                <input name="numday" type="number" min="0" step="1" pattern="\d+"/>
            </div>
        </div>
        <div class="">
            <button class="btn btn-primary" type="subbmit">Submit</button>
            <button class="btn" data-dismiss="modal" >Close</button>
        </div>
    </form>
</div>

<?php $this->endWidget(); ?>
