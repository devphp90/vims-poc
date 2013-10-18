
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
    
    #content #yw6 {
        width: 120%;
    }
    
    #sup-new-item-grid .summary {
        float: right;
        margin-bottom: 5px;
        position: absolute;
        right: 50px;
        text-align: right;
        top: 150px;
        width: 249px;
    }
    
    #page-size {
        width: 100%;
        position: absolute;
        top: 90px;
        right: 100px;
    }
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
//            if(match != '' && $(this).attr("value") == 0)
//                if(!confirm('Are you sure?  This item matches.')) return false;
//            if(match == '' && $(this).attr("value") == 1)
//                if(!confirm('Are you sure?  This item does NOT match.')) return false;
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
    <p>Please carefully decide if each row is a match or not. </p>
    <ol>
        <li>vSKU from another Supplier; then</li>
        <li>MPN+UPC from UBS Items, then</li>
        <li>MPN+Mfg Name from UBS Items, then</li>
        <li>UPC, then</li>
        <li>MPN</li>
    </ol>
    <p>If the match is correct, check "Yes", otherwise No or Undecided.</p>
    
    <p>Please carefully decide if each row is a match or not. <br>
    Also, be careful when clicking the radio buttons, Y/N/U. <br>
    </p>
    <p>
    Yes, No, or Undecided. <br>
    “Y” means that you are accepting this item as a match. <br>
    "N" means that this Supplier Item is NOT a Match to the UBS Product. <br>
    "U" means that you are Undecided. 
    </p>
    <p>Rows with green backgrounds are proposed matches for you to review based upon the criteria in the Match By column.</p>
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


<div class="search-form" style="display:none">

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>

</div><!-- search-form -->


<div id="page-size" class="row" align="right">
<?php
$this->widget('application.extensions.PageSize.PageSize', array(
    'mGridId' => 'sup-new-item-grid',
    'mPageSize' => @$_GET['pageSize'],
    'mDefPageSize' => 100,
));
?>
</div>
<?php
$columns = array(
    array(
        'header' => 'Match<br/>By',
        'name' => 'match_by',
        'value' => '$data->getMatchByStatus()',
        'filter' => array(
            SupItemsNewManage::MATCH_VSKU => 'vSKU',
            SupItemsNewManage::MATCH_MPN_UPC_NAME => 'MPN+UPC+Nam',
            SupItemsNewManage::MATCH_MPN_UPC => 'MPN+UPC',
            SupItemsNewManage::MATCH_MPN_NAME => 'MPN+Nam',
            SupItemsNewManage::MATCH_UPC => 'UPC',
            SupItemsNewManage::MATCH_MPN => 'MPN'
        ),
        'headerHtmlOptions' => array(
            'style' => 'width:23px; ',
        ),
    ),
    array(
        'header' => 'Match<br/>Y/N/U <a href="#" data-toggle="modal" data-target="#match-help" style="display: inline">?</a>',
        'name' => 'match',
        'type' => 'raw',
        'value' => 'CHtml::radioButtonList("match_".$data->id,$data->match, array(1=>"Y",0=>"N",2=>"U"),array(":id"=>$data->id,"class"=>"vsku-$data->sup_vsku","tabindex"=>Yii::app()->controller->tempCounter++,"labelOptions"=>array("style"=>"display:inline;"),"separator"=>" ","template"=>"{label}{input}"))',
        'htmlOptions' => array(
            'style' => 'width:120px;',
        ),
    ),
    array(
        'header' => 'Find',
        'type' => 'raw',
        'value' => 'CHtml::link("Find", "#", array("onclick" => "js:$(\'#ubs-item\').dialog(\'open\');"))',
    ),
    array(
        'header' => '% Diff',
        'name' => 'percent_diff',
        'value' => '!is_null($data->ubsinventory) ? ($data->ubsinventory->price == 0 ? "n/a" : sprintf("%.2f",(abs($data->ubsinventory->price-$data->sup_price)/$data->ubsinventory->price)*100)."%" ) : ""',
        'htmlOptions' => array(
            'style' => 'width:55px;',
        ),
    ),
    array(
        'header' => 'UBS<br/>Item<br/>Cost',
        'value' => '!is_null($data->ubsinventory) ? $data->ubsinventory->price : ""',
        'htmlOptions' => array(
            'style' => 'width:35px; text-align:right',
        ),
    ),
    array(
        'header' => 'Supp<br/>Item<br/>Price',
        'name' => 'sup_price',
        'htmlOptions' => array(
            'style' => 'width:30px; text-align:right',
        ),
    ),
    array(
        'header' => 'Price<br/>Diff',
        'name' => 'price_diff',
        'htmlOptions' => array(
            'style' => 'width:30px; text-align:right',
        ),
        'value' => '(!empty($data->ubsinventory) ? (number_format($data->ubsinventory->price-$data->sup_price, 2)):\'\')',
    ),
    array(
        'header' => 'UBS<br/>SKU',
        'name' => 'ubs_sku',
        'value' => '!is_null($data->ubsinventory) ? $data->ubsinventory->sku : ""',
		 'headerHtmlOptions' => array(
            'style' => 'width:100px;',
        ),
    ),
    array(
        'header' => 'UBS Item Name',
        'type' => 'raw',
        //'value'=>'!is_null($data->ubsinventory) ? ((strlen($data->ubsinventory->sku_name)>40)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->ubsinventory->sku_name."\">".substr($data->ubsinventory->sku_name,0,40)."...</a>":$data->ubsinventory->sku_name) : ""',
        'value' => '!is_null($data->ubsinventory) ? (strlen($data->ubsinventory->sku_name)>100 ? substr($data->ubsinventory->sku_name,0,100) . "..." : $data->ubsinventory->sku_name) : ""',
        'headerHtmlOptions' => array(
            'style' => 'width:1200px;',
        ),
    ),
    array(
        'header' => 'Mfg<br/>Part<br/>Name',
        'name' => 'mfg_part_name',
        'type' => 'raw',
        //'value'=>'(strlen($data->mfg_part_name)>10)?"<a href=\"#\" rel=\"tooltip\" title=\"".$data->mfg_part_name."\">".substr($data->mfg_part_name,0,10)."...</a>":$data->mfg_part_name',
        'value' => 'strlen($data->mfg_part_name)>40 ? substr($data->mfg_part_name,0,40)."..." : $data->mfg_part_name',
        'headerHtmlOptions' => array(
            'style' => 'width:700px;',
        ),
    ),
    array(
        'header' => 'Supp<br/>Mfg<br/>Name',
        'name' => 'mfg_name',
        'type' => 'raw',
        'headerHtmlOptions' => array(
            'style' => 'width:700px;',
        ),
        //'value'=>'(strlen($data->mfg_name)>20)?"<a href=\"#\" title=\"".$data->mfg_name."\" rel=\"tooltip\">".substr($data->mfg_name,0,20)."...</a>":$data->mfg_name',
        'value' => 'strlen($data->mfg_name)>50 ? substr($data->mfg_name,0,50) . "..." : $data->mfg_name',
    ),
    array(
        'header' => 'UBS<br/>Mfg<br/>Name',
        'name' => 'ubsinventory.mfg_title',
        'type' => 'raw',
        //'value' => '!empty($data->ubsinventory) ? (strlen($data->ubsinventory->mfg_title) > 16 ? "<a href=\"#\" title=\"".$data->ubsinventory->mfg_title."\" rel=\"tooltip\">".substr($data->ubsinventory->mfg_title,0,16)."...</a>" : $data->ubsinventory->mfg_title) : ""',
        'value' => '!empty($data->ubsinventory) ? (strlen($data->ubsinventory->mfg_title) > 20 ? substr($data->ubsinventory->mfg_title,0,20)."..." : $data->ubsinventory->mfg_title) : ""',
        'headerHtmlOptions' => array(
            'style' => 'width:350px;',
        ),
    ),
    array(
        'header' => 'Supp<br/>MPN',
        'name' => 'mfg_sku',
		'headerHtmlOptions' => array(
            'style' => 'width:80px;',
        ),
    ),
    array(
        'header' => 'UBS<br/>MPN',
        'name' => 'ubsinventory.mfg_name',
        'value' => '!empty($data->ubsinventory) ? (strlen($data->ubsinventory->mfg_name) > 20 ? substr($data->ubsinventory->mfg_name,0,20)."..." : $data->ubsinventory->mfg_name) : ""',
        'headerHtmlOptions' => array(
            'style' => 'width:350px;',
        ),
    ),
    array(
        'header' => 'Supp<br/>UPC',
        'name' => 'upc',
        'value' => '$data->upc',
    ),
    array(
        'header' => 'UBS<br/>UPC',
        'name' => 'ubsinventory.upc',
        'value' => 'isset($data->ubsinventory->upc)?$data->ubsinventory->upc:""',
    ),
    array(
        'header' => 'Item<br/>Qty',
        'name'=>'qty_total',
        'filter' => array(
            1 => '=0',
            2 => '>0',
            3 => '<0',
            4 => '<>0',
        ),
        'headerHtmlOptions' => array(
            'style' => 'width:80px;',
        ),
        'htmlOptions' => array(
            'style' => 'text-align: right;'
        ),
    ),
    array(
        'header' => 'Will<br/>Auto<br/>Accept?',
        'type' => 'raw',
        'value' => '$data->importStatus != \'Will Import\' ? CHtml::link("no","#",array("rel"=>"tooltip","title"=>$data->importStatus)) : "yes"',
        'htmlOptions' => array(
            'style' => 'width:20px;',
        ),
    ),
);

if (!$supplier) {
    $columns[] = array(
        'header' => 'Supplier',
        'name' => 'sup_id',
        'type' => 'raw',
        'value' => 'isset($data->supplier)?$data->supplier->name.\'(\'.$data->import_routine->sup_id.\')\':"<font color=\"red\">Routine Deleted</font>"',
    );
}

$columns[] = array(
    'header' => 'Info',
    'type' => 'raw',
    'value' => '"<a href=\"#\" class=\"checkernum\" :checkid=\"".$data->id."\" title=\"ubs_id = ". (!is_null($data->ubsinventory) ?$data->ubsinventory->id : 0).",vims_id = ".$data->id.",vsku =".$data->sup_vsku.",import_id=".$data->import_routine->id."\" rel=\"tooltip\">info</a>"',
    'htmlOptions' => array('style' => 'width: 50px'),
    'headerHtmlOptions' => array('style' => 'width: 50px'),
);
$columns[] = array(
    'class' => 'CButtonColumn',
    'template' => '{delete}',
    'htmlOptions' => array(
        'style' => 'width:10px;',
    ),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id' => 'sup-new-item-grid',
    'type' => 'bordered',
    'dataProvider' => $model->searchSupchecker(),
    'ajaxUpdate' => false,
    'ajaxUrl' => $this->createUrl('/supNewItem/supChecker', array('supid' => $supid)),
    'filter' => $model,
    'fixedHeader' => true,
    'headerOffset' => 61,
    'rowCssClassExpression' => '$data->match_by?($data->match?"matched":"mismatched"):""',
    'columns' => $columns,
    'htmlOptions' => array(
        'style' => 'width: 2950px'
    )
));
?>

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

<?php
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'match-help')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>

	<div class="modal-body">
            Hello VIMS User: <?php echo Yii::app()->user->name ?> <br/>
            Please carefully decide if each row is a match or not. <br/>
            Also, be careful when clicking  the radio buttons, Y/N/U. <br/>
            <br/>
            Yes, No,  or Undecided. <br/>
            “Y” means that you are accepting this item as a match. <br/>
            "N" means that this Supplier Item is NOT a Match to the UBS Product. <br/>
            "U" means that you are Undecided. <br/>
            <br/>
            Rows with green backgrounds are proposed matches for you to review based upon the criteria in the Match By column.
	</div>

	<div class="modal-footer">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'type'=>'primary',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'first-pop-up')); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
    </div>


	<div class="modal-body">
            Hello VIMS User: <?php echo Yii::app()->user->name ?> <br/>
            Please carefully decide if each row is a match or not. <br/>
            Also, be careful when clicking  the radio buttons, Y/N/U. <br/>
            Yes, No,  or Undecided. <br/>
            “Y” means that you are accepting this item as a match. <br/>
            Rows with green backgrounds are proposed matches for you to review based upon the criteria in the Match By column.
	</div>

	<div class="modal-footer">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Close',
		'type'=>'primary',
		'url'=>'#',
		'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); ?>
	</div>
<?php $this->endWidget(); ?>

<div style="display:none">
 <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'ubs-item',
            // additional javascript options for the dialog plugin
            'options' => array(
                'width' => '900',
                'height' => '500',
                'title' => 'UBS Items',
                'autoOpen' => false,
                'buttons' => array(
                    array('text' => 'Cancel', 'click' => 'js:function(){ $(this).dialog("close"); }'),
                ),
            ),
        ));
        ?>

<?php
    $ubs = new UbsInventory('search');
    $ubs->unsetAttributes();
    if (isset($_REQUEST['UbsInventory']))
        $ubs->attributes = $_REQUEST['UbsInventory'];

    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'ubs-inventory-grid',
        'dataProvider' => $ubs->search(),
        'filter' => $ubs,
        'columns' => array(
            array(
                'header' => 'Select',
                'type' => 'raw',
                'value' => 'CHtml::link("Select", "javascript:void(0)", array("data-id" => $data->primaryKey, "data-name" => $data->sku, "class" => "btn btn-small btn-success select-ubs"));'
            ),
            'id',
            'sku',
            'sku_name',
        ),
    ));
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>


<script src="<?php echo Yii::app()->request->baseUrl ?>/js/colResizable-1.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        //$("table").colResizable({headerOnly: true});
        $("table.items").removeClass("CRZ");
        
        //if (<?php echo (!isset($_GET['SupItemsNewManage']) ? 1 : 0)?>) 
            //$("#first-pop-up").modal('show');
    });
    
    $('.select-ubs').live('click', function () {
        id = $(this).attr('data-id');
        name = $(this).attr('data-name');
        console.log(name);
        $('#ubs-item').dialog('close');
    });
</script>