<link rel="stylesheet" type="text/css" href="/jquery-easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="/jquery-easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="/jquery-easyui/css/demo.css">
<!--<script type="text/javascript" src="/jquery-easyui/js/jquery.min.js"></script>-->
<script type="text/javascript" src="/jquery-easyui/js/jquery.easyui.min.js"></script>

<style type="text/css">
    .table td,
    .table th
    {
        padding: 0px 2px 2px 0px;

        text-align: left;
    }
    .matched
    {

        background-color: #dff0d8
    }
    .mismatched {background-color: #FCF2F2;}
</style>

<script>
    $(function(){
        var i = 0;
        //jQuery.event.trigger({ type : 'keypress', which : 9 });

        $(document).keydown(function(e){
            if(e.keyCode == 38){

                if($('[tabIndex=' + (i-1) +']').attr('name') != undefined){

                    $('[tabIndex=' + --i +']').focus();
                }
            }
            if(e.keyCode == 40){
                if($('[tabIndex=' + (i+1) +']').attr('name') != undefined){

                    $('[tabIndex=' + ++i +']').focus();
                }
            }
        });

    });
    function checkAllForPage()
    {
        var checkers = '';
        if(!confirm('Are you sure?  Check All Yes if Match for this Page?')) return false;
        $('input:radio').each(function(){
		
            var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');

            if(match != '' && $(this).attr("value") == 1){
                checkers += $(this).parent().find('input').attr(':id') + ',';
                $(this).attr("checked", true);
            }

        });
        $.ajax({
            type: "GET",

            url: "<?php echo $this->createUrl('/supNewItem/updatePageY') ?>",

            data: {

                checkers: checkers,

            },

            success: function(result) {
                alert('Check All Yes done.');
            },

        });
    }

    function checkAllNoForPage()
    {
        var checkers = '';
        if(!confirm('Are you sure?  Check All No if Match for this Page?')) return false;
        $('input:radio').each(function(){

            var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');

            if(match == '' && $(this).attr("value") == 0){
                checkers += $(this).parent().find('input').attr(':id') + ',';
                $(this).attr("checked", true);
            }

        });
        $.ajax({
            type: "GET",

            url: "<?php echo $this->createUrl('/supNewItem/updatePageN') ?>",

            data: {

                checkers: checkers,

            },

            success: function(result) {
                alert('Check All No done.');
            },

        });
    }



    function accept_page()
    {

        if(confirm('Are you sure you want to import this page?')) {
            var checkers = '';
            $(".checkernum").each(function(){
                checkers += $(this).attr(':checkid') + ',';
                console.log($(this).attr(':checkid'));
            });
            var checkerArr = checkers.split(',');
            delete checkerArr[checkerArr.length-1];

            //		jQuery.yii.submitForm(this,'/index.php/supNewItem/import?checkers=' + checkers,{});
            url = '/index.php/supNewItem/importpage?checkers=' + checkers;
            window.open( url , "_blank" );
            return false;
        }
        else
            return false;
    }


    $(function(){

        $('input:radio').click(function(){
            var value = $(this).attr("value");

            var match = $(this).parent().parent().parent().find('td').html().replace('&nbsp;', '');
            if(match != '' && $(this).attr("value") == 0)
                if(!confirm('Are you sure?  This item matches.')) return false;
            if(match == '' && $(this).attr("value") == 1)
                if(!confirm('Are you sure?  This item does NOT match.')) return false;
            //if($(this).attr("value") == 0)
            //
            // check for the rest
            //    console.log($('.'+$(this).attr('class')));
            $.ajax({

                type: "GET",

                url: "<?php echo $this->createUrl('/supNewItem/updateMatch') ?>",

                data: {

                    id: $(this).attr(":id"),
                    value: $(this).attr("value")

                },

                success: function(result) {
                    if (value == 1) {
                        location.reload();
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {

                },

            });
        });
    });

</script>

<span id="match_391942">
    <label for="match_391942_0" style="display:inline;">Y</label><input type="radio" name="match_391942" id="match_391942_0" value="1" tabindex="1" class="vsku-a888" > 
    <label for="match_391942_1" style="display:inline;">N</label><input type="radio" name="match_391942" id="match_391942_1" value="0" tabindex="1" class="vsku-a888" > 
    <label for="match_391942_2" style="display:inline;">U</label><input type="radio" name="match_391942" checked="checked" id="match_391942_2" value="2" tabindex="1" class="vsku-a888">
</span>

<?php
$this->breadcrumbs = array(
    'Sup New Items' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List', 'url' => array('index')),
    array('label' => 'Delete All', 'url' => '#', 'linkOptions' => array('submit' => array('deleteAll?id=' . $supid), 'confirm' => 'Are you sure you want to delete all item?')),
    array('label' => 'Delete All MisMatch', 'url' => '#', 'linkOptions' => array('submit' => array('deleteAllMarkedAsMisMatch?id=' . $supid), 'confirm' => 'Are you sure you want to delete all items marked as mismatch?')),
    //array('label'=>'Accept All', 'url'=>'#', 'linkOptions'=>array('submit'=>array('import'),'confirm'=>'Are you sure you want to import all item?','target'=>'_blank')),
    array('label' => 'Accept All', 'url' => '#', 'linkOptions' => array('title' => 'Under Construction')),
    array('label' => 'Accept Page', 'url' => '#', 'linkOptions' => array('onclick' => 'accept_page();', 'target' => '_blank')),
    array(
        'label' => 'Help',
        'url' => '#',
        'linkOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#accept',
        ),
    ),
    array('label' => 'Check All Yes if Match for this Page', 'url' => '#', 'linkOptions' => array('onclick' => 'checkAllForPage();')),
    array('label' => 'Check All No if Not Match for this Page', 'url' => '#', 'linkOptions' => array('onclick' => 'checkAllNoForPage();')),
    array('label' => 'Search/Filter', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
);



Yii::app()->clientScript->registerScript('search', "

$('.search-button').click(function(){

	$('.search-form').toggle();

	return false;

});

$('.search-form form').submit(function(){

	$.fn.yiiGridView.update('sup-new-item-grid', {

		data: $(this).serialize()

	});

	return false;

});

");
?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'accept')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
</div>


<div class="modal-body">
    <p>VIMS proposes a match based on:</p>
    <ol>
        <li>vSKU from another Supplier; then</li>
        <li>MPN+UPC from UBS Items, then</li>
        <li>MPN+Mfg Name from UBS Items, then</li>
        <li>UPC, then</li>
        <li>MPN</li>
    </ol>
    <p>If the match is correct, check "Yes", otherwise No or Undecided.</p>
</div>

<div class="modal-footer">


<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Close',
    'url' => '#',
    'htmlOptions' => array('data-dismiss' => 'modal'),
));
?>
</div>
<?php $this->endWidget(); ?>

<?php if ($supplier): ?>
    <h1>Manage Supplier New Items ("Checkers"): <?= $supplier->name; ?></h1>
<?php else: ?>
    <h1>Manage Supplier New Items ("Checkers") for ALL Suppliers</h1>
    <?php endif; ?>


<div class="row" align="right">
<?php
$this->widget('application.extensions.PageSize.PageSize', array(
    'mGridId' => 'sup-new-item-grid',
    'mPageSize' => @$_GET['pageSize'],
    'mDefPageSize' => 100,
));
?>
</div>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
</div>


<div class="modal-body">
    <p>VIMS proposes a match based on:</p>
    <ol>
        <li>vSKU from another Supplier; then</li>
        <li>MPN+UPC from UBS Items, then</li>
        <li>MPN+Mfg Name from UBS Items, then</li>
        <li>UPC, then</li>
        <li>MPN</li>
    </ol>
    <p>If the match is correct, check "Yes", otherwise No or Undecided.</p>
</div>

<div class="modal-footer">


<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Close',
    'url' => '#',
    'htmlOptions' => array('data-dismiss' => 'modal'),
));
?>
</div>
<?php $this->endWidget(); ?>

<!--<p> We are pleased to see you connected to the Eagle South Africa Ethical Clearance Site </p>-->

<!--<h2>Frozen Columns in DataGrid</h2>
<div class="demo-info">
    <div class="demo-tip icon-tip"></div>
    <div>You can freeze some columns that can't scroll out of view.</div>
</div>
<div style="margin:10px 0;"></div>-->


<table id="dg" class="easyui-datagrid" title="Manage Supplier New Items" style="width:auto;height:250px"
        data-options="rownumbers:true,singleSelect:true,method:'get'">
    <thead data-options="frozen:true">
        <tr>
            <th data-options="field:'matchby',width:60">Match By</th>
            <th data-options="field:'match',width:120">Match</th>
            <th data-options="field:'diff',width:90,align:'right'">% Diff</th>
            <th data-options="field:'ubs_item_cost',width:60,align:'right'">UBS Item Cost</th>
            <th data-options="field:'supp_item_price',width:60">Supp Item Price</th>
            <th data-options="field:'price_diff',width:60,align:'center'">Price Diff</th>
            <th data-options="field:'ubs_sku',width:120,align:'center'">UBS SKU</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th data-options="field:'ubs_item_name',width:120,align:'center'">UBS Item Name</th>
            <th data-options="field:'mfg_part_name',width:120,align:'center'">Mfg Part Name</th>
            <th data-options="field:'supp_mfg_name',width:120,align:'center'">Supp Mfg Name</th>
            <th data-options="field:'ubs_mfg_name',width:120,align:'center'">UBS Mfg Name</th>
            <th data-options="field:'supp_mpn',width:120,align:'center'">Supp MPN</th>
            <th data-options="field:'ubs_mpn',width:120,align:'center'">UBS MPN</th>
            <th data-options="field:'supp_upc',width:120,align:'center'">Supp UPC</th>
            <th data-options="field:'ubs_upc',width:120,align:'center'">UBS UPC</th>
            <th data-options="field:'will_auto_accept',width:60,align:'center'">Will Auto Accept?</th>
            <th data-options="field:'info',width:60,align:'center'">Info</th>
            <th data-options="field:'delete',width:60,align:'center'">Delete</th>
        </tr>
    </thead>
</table>




<?php 
Yii::app()->clientScript->registerScript('load', "
    jQuery(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: '" . Yii::app()->createAbsoluteUrl('/supNewItem/getData') . "',
            dataType: 'json',
            data : {supid: " . $supid . "},
            success: function (response) {
                $('#dg').datagrid('loadData', response);
            }
        });
    });
", CClientScript::POS_HEAD);
?>
