<?php
$this->widget('bootstrap.widgets.TbExtendedGridView',array(
  'id'=>'tabs-import-log-grid',
  'dataProvider'=>$dataProvider,
  'filter'=>$model,
  'fixedHeader' => true,
  'headerOffset' => 61,
  'columns'=>array(
/*
    array(
      'header' => 'User<br/>Action',
      'type' => 'raw',
      'value' => 'CHtml::dropDownList("Action", "", array("Try Again", "Accept the failed import sheet1", "Accept the failed import sheet2 and reactivate", "Accept failed importsheet BOTH and reactivate", "REJECT and Reset/requeu to the previous GOOD inventory sheet and reactivate", "REJECT and keep on Inactive"))',
    ),
*/

    array(
      'header'=>'Supplier',
      //'name'=>'create_time',
      'value'=>'$data->tab->supplier->name',
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
      'header'=>'Sheet 1<br/>Date/Time<br/>Stamp',
      'name'=>'filetime',
      'value'=>'$data->filetime?date("Y-m-d H:i:s",$data->filetime):""',
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
    array(
      'header'=>'Sheet 2<br/>Date/Time<br/>Stamp',
      'name'=>'filetime2',
      'value'=>'$data->filetime2?date("Y-m-d H:i:s",$data->filetime2):""',
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
      'header'=>'Import Finish<br/>vSheet Start',
      'name'=>'download_finish_time',
      'type'=>'raw',
      'value'=>'$data->download_finish_time."<br/>".(strtotime($data->download_finish_time)-strtotime($data->create_time)>0?strtotime($data->download_finish_time)-strtotime($data->create_time):"0")." Secs"',
      'htmlOptions' => array('style' => 'width: 7%;'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header'=>'vSheet Finish',
      'name'=>'finish_time',
      'type'=>'raw',
      'value'=>'$data->finish_time."<br/>".(strtotime($data->finish_time)-strtotime($data->download_finish_time)>0?strtotime($data->finish_time)-strtotime($data->download_finish_time):"0")." Secs"',
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