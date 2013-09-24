<?php
/** @var CSqlDataProvider $dataProvider  */
$this->breadcrumbs=array(
    'Import Logs'=>array('index'),
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
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tabs-import-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1> Manage Supplier Failed Imports and Updates</h1>

<?php

$this->widget('bootstrap.widgets.TbExtendedGridView',array(
    'id'=>'tabs-import-log-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$model,
    'fixedHeader' => true,
    'headerOffset' => 61,
    'enableSorting' => false,
    'columns'=>array(
        array(
            'header'=>'Action',
            'type' => 'raw',
            'value'=> '$data["tabs_import_log_id"] ? CHtml::link("Action", "#", array("data-toggle" => "modal","data-target"=>"#myModal", "tabs_id" => $data["tabs_id"], "tabs_import_log_id" => $data["tabs_import_log_id"], "class" => "user-action")) : ""'
        ),
        array(
            'header'=>'Supplier',
            //'name'=>'create_time',
            'type' => 'raw',
            'value'=> 'CHtml::link(Yii::app()->controller->getTabs($data["tabs_id"])->supplier->name, Yii::app()->createUrl("tabs/update", array("id" => $data["tabs_id"])))',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header' => 'Reset Log',
            'value' => '$data["tabs_import_log_id"] ? CHtml::link("Reset", array("supreset", "id"=>$data["tabs_id"])) : ""',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
            'type' => 'raw',
        ),
        array(
            'header' => 'Active<br/>Inactive<br/>Status',
            'type' => 'raw',
            'value' => '$data["tabs_import_log_id"] ? CHtml::link(Yii::app()->controller->getTabs($data["tabs_id"])->supplier->active?"Active":"Inactive", Yii::app()->createUrl("/supplier/statusChangeInfo", array("id"=>Yii::app()->controller->getTabs($data["tabs_id"])->supplier->id)), array("id" => "link-status-".Yii::app()->controller->getTabs($data["tabs_id"])->supplier->id, "class" => "status-toggle"))
        . CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("/supplier/statusChangeInfo", array("id"=>Yii::app()->controller->getTabs($data["tabs_id"])->supplier->id, "edit-only" => 1)), array("class"=> "status-toggle")) : ""',
            'htmlOptions' => array('style' => 'width: 70px'),
            'headerHtmlOptions' => array('style' => 'width: 70px'),
        ),
        array(
            'header' => 'Run Import Update',
            'type' => 'raw',
            'value' => '$data["tabs_import_log_id"] ? CHtml::link("Run I/U",array("/importRoutine/triggleIU","id"=>$data["tabs_id"])) : ""',
            'htmlOptions' => array('style' => 'width: 70px'),
            'headerHtmlOptions' => array('style' => 'width: 70px'),
        ),
        array(
            'header'=>'Import Start<br/>Date/Time',
            'name'=>'create_time',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet 1 <br/>File',
            'type'=>'raw',
            'value'=>'\'<a href="\'.$data["sheet1_url"].\'">\'.substr(trim(basename($data["sheet1_url"]),Yii::app()->controller->getTabs($data["tabs_id"])->importRoutine->id),34).\'</a>\'',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet 2 <br/>File',
            'type'=>'raw',
            'value'=>'\'<a href="\'.$data["sheet2_url"].\'">\'.substr(trim(basename($data["sheet2_url"]),Yii::app()->controller->getTabs($data["tabs_id"])->importRoutine->id),34).\'</a>\'',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet1<br/>Download<br/>Status',
            'name'=>'download_sheet1_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["download_sheet1_status"]]."<br/>".$data["download_sheet1_reason"]',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet2<br/>Download<br/>Status',
            'name'=>'download_sheet2_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["download_sheet2_status"]]."<br/>".$data["download_sheet2_reason"]',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Data Integrity<br/>Column Type',
            'name'=>'data_integrity_type_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["data_integrity_type_status"]]."<br/>".$data["data_integrity_type_reason"]',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Data Integrity<br/>Column Count',
            'name'=>'data_integrity_count_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["data_integrity_count_status"]]."<br/>Count:".$data["column_count"]."<br/>".$data["data_integrity_count_reason"]',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Data Integrity<br/>Row Count',
            'name'=>'overall_item_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["overall_item_status"]]."<br/>Count:".$data["item"].$data["overall_item_reason"]',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet 1<br/>Date/Time<br/>Stamp',
            'name'=>'filetime',
            'value'=>'$data["filetime"]?date("Y-m-d H:i:s",$data["filetime"]):""',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet 2<br/>Date/Time<br/>Stamp',
            'name'=>'filetime2',
            'value'=>'$data["filetime2"]?date("Y-m-d H:i:s",$data["filetime2"]):""',
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        //Update Column
        array(
            'header'=>'Sheet Changes <br/>Qty and/or Price<br/>PASS/FAIL <a href="#" rel="tooltip" title="A sheet could FAIL if a % of Items change QTY and/or Price. If Rule=50%, and 51% of Items had a Price change from last Update, then FAIL. If 25% had a QTY change AND 26% had a Price change, then FAIL." style="display:inline;">(?)</a>',
            'name'=>'data_integrity_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["data_integrity_status"]]."<br/>".$data["data_integrity_reason"]',
            'sortable'=>false,
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
        array(
            'header'=>'Sheet Changes <br/>Items InStock<br/>PASS/Fail <a href="#" rel="tooltip" title="FAIL if % of Items change stock status.  If Rule=20%, and 30% go from InStock to BO, then FAIL. Buffer rules apply to determine stock status." style="display:inline;">(?)</a>',
            'name'=>'instock_item_status',
            'type'=>'raw',
            'value'=>'Yii::app()->controller->_status[$data["instock_item_status"]]."<br/>".$data["instock_item_reason"]',
            'sortable'=>false,
            'htmlOptions' => array('style' => 'width: 7%;'),
            'headerHtmlOptions' => array('style' => 'width: 7%'),

        ),


    ),
));
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Choose Action</h4>
</div>
<div class="modal-body">
    <?php
    $this->renderPartial('_user_action_form');
    ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=> 'Save and Take Action',
        'htmlOptions'=>array(
            'onclick' => '$("#user_action_form").submit();'
        ),
    ));
    ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $('.user-action').click(function () {
        tabs_id = $(this).attr('tabs_id');
        tabs_import_log_id = $(this).attr('tabs_import_log_id');
        $('#tabs_id').val(tabs_id);
        $('#tabs_import_log_id').val(tabs_import_log_id);
    })
</script>