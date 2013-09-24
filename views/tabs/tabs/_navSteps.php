<?php
//$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
//  'id'=>'frm-nav-steps',
//  'enableAjaxValidation'=>false,
//  'type'=>'horizontal',
//
//));
?>
 <?= $form->textFieldRow($navsup_model,'supplier_name',array('readOnly'=>'readOnly'));?>
  <?= $form->textFieldRow($navsup_model,'url',array('placeholder'=>'Url'));?>

  <?= $form->textFieldRow($navsup_model,'username_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($navsup_model,'username',array('placeholder'=>'Username')); ?>

  <?= $form->textFieldRow($navsup_model,'password_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($navsup_model,'password',array('placeholder'=>'Password')); ?>

  <?= $form->textFieldRow($navsup_model,'logon_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($navsup_model,'step2_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($navsup_model,'step3_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step4_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step5_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step6_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step7_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step8_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step9_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'step10_label',array('placeholder'=>'')); ?>
  <?= $form->textFieldRow($navsup_model,'download_link',array('placeholder'=>'')); ?>
<div id="div-downloaded-file" class="control-group" style="display: none">
  <label class="control-label">File downloaded here: </label>
  <div class="controls">
    <a href="">file here</a>
  </div>
</div>
  <div class="control-group">
    <div class="controls">
      <button id="btn-nav-steps-save" class="btn-primary">Save</button>
      <button id="btn-nav-steps-run" >Run</button>
    </div>
  </div>
<?php //$this->endWidget(); ?>


<script type="text/javascript">
  $('#btn-nav-steps-save').bind('click', function(){
    var data = $('#tabs-form').serialize();
    $.post('/index.php/supplier/navSteps?id=<?= $model->supplier_id; ?>&save-only=1', data, function(data){
      alert('Saved successfully!');
    });

    return false;
  });

  $('#btn-nav-steps-run').bind('click', function(){
    var data = $('#tabs-form').serialize();

    $.post('/index.php/supplier/navSteps?id=<?= $model->supplier_id; ?>', data, function(data){
      $('a', '#div-downloaded-file').attr('href', data).html(data);
      $('#div-downloaded-file').show();
    });

    return false;
  });
</script>