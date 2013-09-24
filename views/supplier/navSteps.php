<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'frm-nav-steps',
  'enableAjaxValidation'=>false,
  'type'=>'horizontal',
  'method' => 'POST'
)); ?>
  <div class="control-group ">
    <label class="control-label">Supplier Name</label>
    <div class="controls">
      <?php

      $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'id' => 'txt-supplier',
        'attribute'=>'supplier_name',
        'model' => $model,
        'source'=>$this->createUrl('/supplier/autocompleteSup'),
        'options'=>array(
          'minLength' => 1,
          //'change'=>'js:function(){$(this).val($(this).val().match(/(\d+)/)[1]);}',
        ),

      ));

      ?>
    </div>
  </div>

  <?= $form->textFieldRow($model,'url',array('placeholder'=>'Url')); ?>

  <?= $form->textFieldRow($model,'username_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($model,'username',array('placeholder'=>'Username')); ?>

  <?= $form->textFieldRow($model,'password_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($model,'password',array('placeholder'=>'Password')); ?>

  <?= $form->textFieldRow($model,'logon_label',array('placeholder'=>'')); ?>

  <?= $form->textFieldRow($model,'step2_label',array('placeholder'=>'')); ?>

  <div class="control-group">
    <div class="controls">
      <button type="submit">Run</button>
    </div>
  </div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
  $("#txt-supplier").on("autocompleteselect", function(event, ui) {
    $.get('/index.php/supplier/queryId?name=' + ui.item.value, function(data){
//      console.log(data);
      window.location = '/index.php/supplier/navSteps?id=' +data;
    })
  });
</script>