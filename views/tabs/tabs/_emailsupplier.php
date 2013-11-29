<div class="form-row">
    <?php //echo $form->labelEx($model, 'from_email'); ?>
    <?php
    $this->widget('application.extensions.editor.CKkceditor', array(
        "model" => $supplierModel, # Data-Model
        "attribute" => 'from_email', # Attribute in the Data-Model
        "height" => '200px',
        "width" => '98%',
            //'config' => array('toolbar' => 'Basic'),
    ));
    ?>
    <?php echo $form->error($model, 'from_email'); ?>
</div>