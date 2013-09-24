<?php
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

<h1>Supplier Failed Import List</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

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
      'header' => 'User<br/>Action',
      'type' => 'raw',
      'value' => 'CHtml::dropDownList("Action", "", array("Try Again", "Accept the failed import sheet1", "Accept the failed import sheet2 and reactivate", "Accept failed importsheet BOTH and reactivate", "REJECT and Reset/requeu to the previous GOOD inventory sheet and reactivate", "REJECT and keep on Inactive"))',
      'headerHtmlOptions' => array('style' => 'background-color:#fcf8e3'),
      'htmlOptions'=> array('style' => 'background-color:#fcf8e3'),
    ),
    
    array(
      'header' => 'Reason',
      'type' => 'raw',
      'value' => 'CHtml::dropDownList("reason", "", array("Remapped sheet","Change QA rule","Other"))',
      'headerHtmlOptions' => array('style' => 'background-color:#fcf8e3'),
      'htmlOptions'=> array('style' => 'background-color:#fcf8e3'),
    ),

    array(
      'header'=>'Supplier',
      //'name'=>'create_time',
      'value'=>'$data->tab->supplier->name',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
        'header' => 'Reset Log',
        'value' => 'CHtml::link("Reset", array("supreset", "id"=>$data->tabs_id))',
        'htmlOptions' => array('style' => 'width: 7%;'),
        'headerHtmlOptions' => array('style' => 'width: 7%'),
        'type' => 'raw',
    ),
    array(
      'header' => 'Active<br/>Inactive<br/>Status',
      'name' => 'tab.supplier.active',
      'type' => 'raw',
      'value' => 'CHtml::link($data->tab->supplier->active?"Active":"Inactive", Yii::app()->createUrl("/supplier/statusChangeInfo", array("id"=>$data->tab->supplier->id)), array("id" => "link-status-".$data->tab->supplier->id, "class" => "status-toggle"))
        . CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("/supplier/statusChangeInfo", array("id"=>$data->tab->supplier->id, "edit-only" => 1)), array("class"=> "status-toggle"))',
      'htmlOptions' => array('style' => 'width: 70px'),
      'headerHtmlOptions' => array('style' => 'width: 70px'),
    ),

    

    array(
      'header'=>'Sheet 1 <br/>File',
      'type'=>'raw',
      'value'=>'\'<a href="\'.$data->sheet1_url.\'">\'.substr(trim(basename($data->sheet1_url),$data->tab->importRoutine->id),34).\'</a>\'',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Sheet 2 <br/>File',
      'type'=>'raw',
      'value'=>'\'<a href="\'.$data->sheet2_url.\'">\'.substr(trim(basename($data->sheet2_url),$data->tab->importRoutine->id),34).\'</a>\'',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Sheet1<br/>Download<br/>Status',
      'name'=>'download_sheet1_status',
      'type'=>'raw',
      'value'=>'$data->_status[$data->download_sheet1_status]."<br/>".$data->download_sheet1_reason',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    
    array(
      'header'=>'Sheet2<br/>Download<br/>Status',
      'name'=>'download_sheet2_status',
      'type'=>'raw',
      'value'=>'$data->_status[$data->download_sheet2_status]."<br/>".$data->download_sheet2_reason',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    
    /*
        array(
          'header'=>'Data Integrity<br/>Column Type<br/>Column Count',
          'name'=>'data_integrity_status',
          'type'=>'raw',
          'value'=>'$data->_status[$data->data_integrity_status]."<br/>".$data->data_integrity_reason',
          'htmlOptions' => array('style' => 'width: 7%;'),
          'headerHtmlOptions' => array('style' => 'width: 7%'),
        ),
    */
    array(
      'header'=>'Data Integrity<br/>Column Type',
      'name'=>'data_integrity_type_status',
      'type'=>'raw',
      'value'=>'$data->_status[$data->data_integrity_type_status]."<br/>".$data->data_integrity_type_reason',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Data Integrity<br/>Column Count',
      'name'=>'data_integrity_count_status',
      'type'=>'raw',
      'value'=>'$data->_status[$data->data_integrity_count_status]."<br/>Count:".$data->column_count."<br/>".$data->data_integrity_count_reason',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Data Integrity<br/>Row Count',
      'name'=>'overall_item_status',
      'type'=>'raw',
      'value'=>'$data->_status[$data->overall_item_status]."<br/>Count:".$data->item.$data->overall_item_reason',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Sheet 1<br/>Date/Time<br/>Stamp',
      'name'=>'filetime',
      'value'=>'$data->filetime?date("Y-m-d H:i:s",$data->filetime):""',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Sheet 2<br/>Date/Time<br/>Stamp',
      'name'=>'filetime2',
      'value'=>'$data->filetime2?date("Y-m-d H:i:s",$data->filetime2):""',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'Import Start<br/>Date/Time',
      'name'=>'create_time',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),

    array(
      'header'=>'Import Finish',
      'name'=>'download_finish_time',
      'type'=>'raw',
      'value'=>'$data->download_finish_time."<br/>".(strtotime($data->download_finish_time)-strtotime($data->create_time)>0?strtotime($data->download_finish_time)-strtotime($data->create_time):"0")." Secs"',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
  
    array(
      'name' => 'status',
      'htmlOptions' => array('style' => 'width: 5%;'),
      'headerHtmlOptions' => array('style' => 'width: 5%'),
    ),
    array(
      'name' => 'id',
      'htmlOptions' => array('style' => 'width: 5%;'),
      'headerHtmlOptions' => array('style' => 'width: 5%'),
    ),
    array(
      'header'=>'Tab Id',
      'name'=>'id',
      'htmlOptions' => array('style' => 'width: 5%;'),
      'headerHtmlOptions' => array('style' => 'width: 5%'),
    ),
    array(
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'htmlOptions' => array('style' => 'width: 150px;'),
      'headerHtmlOptions' => array('style' => 'width: 150px;'),
    ),
  ),
));