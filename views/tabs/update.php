<?php
$this->breadcrumbs = array(
    'Supplier Setup' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'Create', 'url' => array('create')),
    array('label' => 'Manage', 'url' => array('admin')),
    array(
        'label' => 'Help',
        'url' => '#',
        'linkOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
        ),
    ),
    array('label' => 'Run I/U', 'url' => array('importRoutine/triggleIU', 'id' => $model->id)),
	array('label' => '<span style="color:black">Update by: <strong>'.(isset($supplierModel->update_user) ? $supplierModel->update_user->username : "").'</strong>
		at:  <strong>'.(!empty($supplierModel->update_time || $supplierModel->update_time != '0000-00-00 00:00:00') ? $supplierModel->update_time : "").'
	</strong></span>', 'visible' => isset($supplierModel->update_user), 'url' => ''),
);
?>

<h1>Supplier Setup: <?php echo $supplierModel->name ?> <span style="font-weight: normal; font-size: 15px; margin-left: 20px;">UBS Supplier ID: <b><?php echo $supplierModel->ubs_supplier_id ?></b> &nbsp;&nbsp;VIMS Supplier ID1: <b><?php echo $model->supplier_id ?></b> &nbsp;&nbsp;VIMS Supplier ID2: <b><?php echo $model->id ?></b></span></h1>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Help</h4>
</div>


<div class="modal-body">
    Be sure to review, "What row does data start with?"<br/>
    Remember to click, Save in Sheet Info tab.
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
<?php $this->renderPartial('_tabform', compact('model', 'supplierModel', 'importRoutineModel', 'importRoutineModel2', 'columns', 'navsup_model', 'emailTabOnly')); ?>


<script>
    function sendCode()
    {
        $.ajax({
            url: '<?php echo $this->createUrl('freshUpdate', array('id' => $model->id)) ?>',
            type: 'POST',
            success: function (res) {

            }
        })
    }
    var interval = setInterval(sendCode, 5000);

    $('li a[data-toggle]').click(function () { 
        $('#tabindex').val($(this).attr('href'));
    });
<?php
if (isset($_REQUEST['tabindex'])) {
    ?>
        $('a[href="<?php echo $_REQUEST['tabindex'] ?>"]').tab('show');
    <?php
}
?>
	
<?php if ($model->importRoutine->hasErrors()) { ?>

        $('a[href="#tabs_5"]').tab('show');
        $('.help-inline.error').hide();
<?php } ?>
	
	
</script>
