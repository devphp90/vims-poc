<?php
$columns = array();

if ($supplierOnly) {
  $columns = array(
    array(
      'type' => 'raw',
      'name' => 'supplier_name',
      'value' => 'CHtml::link($data->supplier->name,array("update","id"=>$data->id, "type"=>"dashboard"))',
      'htmlOptions' => array('style' => 'width: 10%'),
      'headerHtmlOptions' => array('style' => 'width: 10%'),
    )
  );
} else {
  $columns = array(
    array(
      'type' => 'raw',
      'name' => 'supplier_name',
      'value' => 'CHtml::link($data->supplier->name,array("update","id"=>$data->id))',
      'htmlOptions' => array('style' => 'width: 10%'),
      'headerHtmlOptions' => array('style' => 'width: 10%'),
    ),
    array(
      'header' => 'Supplier<br/>Items',
      'type' => 'raw',
      'value' => 'CHtml::link(\'Supp Items\',array(\'/supInventory/supview\',\'id\'=>$data->id),array())',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'Active<br/>Inactive<br/>Status',
      'name' => 'supplier.active',
      'type' => 'raw',
      'value' => 'CHtml::link($data->supplier->active?"Active":"Inactive", Yii::app()->createUrl("/supplier/statusChangeInfo", array("id"=>$data->supplier->id)), array("id" => "link-status-".$data->supplier->id, "class" => "status-toggle"))
        . CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("/supplier/statusChangeInfo", array("id"=>$data->supplier->id, "edit-only" => 1)), array("class"=> "status-toggle"))',
      'htmlOptions' => array('style' => 'width: 70px'),
      'headerHtmlOptions' => array('style' => 'width: 70px'),
    ),
    array(
      'header' => 'Auto<br/>I/U<br/>Status',
      'type' => 'raw',
      'htmlOptions' => array(
        'width' => '60',
      ),
      'value' => 'CHtml::ajaxLink($data->importRoutine->status==1?"On":"Off",Yii::app()->controller->createUrl("/ImportRoutine/ajaxStatus",array("id"=>$data->importRoutine->id)),array(
				"success"=>\'function(res){$("#iustatus_\'.$data->importRoutine->id.\'").html(res)}\',

			),array(
				"id"=>"iustatus_".$data->importRoutine->id,

			));',
    ),
    array(
      'header' => 'Auto<br/>I/U<br/>Freq.',
      'name' => 'importRoutine.frequency',
      'value' => '!empty($data->importRoutine->frequency)?$data->importRoutine->frequency."  ".$data->importRoutine->frequency_term:""',
      'htmlOptions' => array('style' => 'width: 60px'),
      'headerHtmlOptions' => array('style' => 'width: 60px'),
    ),
    array(
      'header' => 'Run<br/>Import<br/>Update',
      'type' => 'raw',
      'value' => 'CHtml::link("Run I/U",array("/importRoutine/triggleIU","id"=>$data->id))',
    ),
    array(
      'header' => 'Import<br/>Log',
      'type' => 'raw',
      'value' => 'CHtml::link(\'Import Log\',array(\'/tabsImportLog/logview\',\'id\'=>$data->id),array())',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'vSheet',
      'type' => 'raw',
      'value' => 'CHtml::link(\'vSheet\',array(\'/importVsheet/vsheetview\',\'id\'=>$data->id),array())',
    ),
    array(
      'header' => 'Update Log',
      'type' => 'raw',
      'value' => 'CHtml::link(\'Update Log\',array(\'/tabsUpdateLog/logview\',\'id\'=>$data->id),array())',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'Manage<br/>New Items<br/>("Checkers")',
      'type' => 'raw',
      'value' => 'CHtml::link(\'Checkers\',array(\'/supNewItem/supChecker\',\'supid\'=>$data->supplier->id),array())',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'New Items',
      'type' => 'raw',
      'value' => 'CHtml::link("New Items", array("supNewItem/noMatch", "sup_id"=>$data->supplier->id))',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'Mis Match<br/>Items',
      'type' => 'raw',
      'value' => 'CHtml::link("MisMatch Items", array("supNewItem/misMatch", "sup_id"=>$data->supplier->id))',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'Missing<br/>Items',
      'type' => 'raw',
      'value' => 'CHtml::link("Missing", array("supInventory/dropItem", "supplierId" => $data->supplier->id))',
      'htmlOptions' => array('style' => 'width: 80px'),
      'headerHtmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
      'header' => 'Items with<br/>Price<br/>Warning',
      'type' => 'raw',
      'value' => 'CHtml::link(\'Price Warning\',array(\'/importWarnitemPrice/supview\',\'id\'=>$data->id),array())',
      'htmlOptions' => array('style' => 'width: 7%'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header' => 'Items with<br/>Qty<br/>Warning',
      'type' => 'raw',
      'value' => 'CHtml::link(\'Qty Warning\',array(\'/importWarnitemQty/supview\',\'id\'=>$data->id),array())',
      'htmlOptions' => array('style' => 'width: 7%'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'header' => 'Items<br/>InStock',
      'value' => 'SupInventory::model()->countByAttributes(array("sup_id"=>$data->supplier_id,"sup_status"=>1))',
    ),
    array(
      'header' => 'Items<br/>BackOrder',
      'value' => 'SupInventory::model()->countByAttributes(array("sup_id"=>$data->supplier_id),"sup_status!=1")',
    ),
    array(
      'name' => 'create_time',
      'htmlOptions' => array('style' => 'width: 7%'),
      'headerHtmlOptions' => array('style' => 'width: 7%'),
    ),
    array(
      'name' => 'id',
      'htmlOptions' => array('style' => 'width: 50px'),
      'headerHtmlOptions' => array('style' => 'width: 50px'),
    ),
    array(
      'class' => 'bootstrap.widgets.TbButtonColumn',
    ),
  );
}
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id' => 'tabs-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'fixedHeader' => true,
    'headerOffset' => 61,
    'ajaxUpdate' => false,
    'columns' => $columns
));
?>

<script type="text/javascript">
    $('document').ready(function(){
        $('.status-toggle').bind('click', function() {
            // Fetch and show popup
            $.get($(this).attr('href'), function(data) {
                $('.modal-body', '#status-change-modal').html(data);
                $('#status-change-modal').modal('show');
            })

            return false;
        });

        $('#btn-save-status').bind('click', function() {
            var data = $('#frm-status-change-info').serialize();

            $.post('/index.php/supplier/statusChangeInfo', data, function(data) {
                $('#status-change-modal').modal('hide');
                //        $.fn.yiiGridView.update('tabs-grid');
                //        console.log(data);
                $('#link-status-'+data.supplier_id).text(data.status);
            }, 'json')

            return false;
        })
    })
</script>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'status-change-modal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
    <h4>Status Change Details</h4>
</div>
<div class="modal-body">

</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal">Close</button>
    <button id="btn-save-status" class="btn btn-primary">Save</button>
</div>
<?php $this->endWidget(); ?>