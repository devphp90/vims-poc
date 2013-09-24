<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'email-suppliers-form',
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'supplier_name'); ?>

<div class="form-row">
    <?php echo $form->labelEx($model, 'content'); ?>
    <?php
    $this->widget('application.extensions.editor.CKkceditor', array(
        "model" => $model, # Data-Model
        "attribute" => 'content', # Attribute in the Data-Model
        "height" => '200px',
        "width" => '98%',
            //'config' => array('toolbar' => 'Basic'),
    ));
    ?>
    <?php echo $form->error($model, 'content'); ?>
</div>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScript('mytext', "jQuery('#EmailSuppliers_supplier_name').autocomplete({'source':'/index.php/supplier/autocompleteSup'});");
?>