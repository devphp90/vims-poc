<?php
/** @var TbActiveForm $form
 * @var TabsImportLogController $this
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user_action_form',
    'enableAjaxValidation' => false,
    'type' => 'vertical',
));

$actions = $this->getUserActions();
$reasons = $this->getUserReasons();
$tooltips = $this->getUserActionTooltips();
?>
<div class="controls">
    <?php foreach ($actions as $key => $item) :?>
    <label class="radio">
        <input checked="checked" type="radio" value="<?php echo $key ?>" name="action" id="TestForm_radioButtons_0<?php echo $key?>">
        <label for="TestForm_radioButtons_0<?php echo $key?>" title="<?php echo $tooltips[$key] ?>">
            <?php echo $item?>
        </label>
    </label>
    <?php endforeach;?>
</div> <br>
<h4>Choose reason:</h4>
<div class="controls">
    <?php foreach ($reasons as $key => $item) :?>
    <label class="radio">
        <input checked="checked" type="radio" value="<?php echo $key ?>" name="reason" id="TestForm_radioButtons_1<?php echo $key?>">
        <label for="TestForm_radioButtons_1<?php echo $key?>">
            <?php echo $item?>
        </label>
    </label>
    <?php endforeach;?>

</div>

    <div class="controls">
        <label class="control-label"> Notes: </label>
        <div class="controls">
            <textarea name="notes" cols="800" rows="2" style="width: 500px"></textarea>
        </div>
    </div>
<label class="control-label">Last Action: <span id="last_action"></span></label>
<label class="control-label">Date/Time: <span id="date_time_last_action"></span></label>
<label class="control-label">Reason: <span id="last_action_reason"></span></label>
<label class="control-label">User: <span id="last_action_user"></span></label>
<label class="control-label">Notes: <span id="last_action_note"></span></label>
<input type="hidden" name="tabs_id" id="tabs_id" />
<input type="hidden" name="tabs_import_log_id" id="tabs_import_log_id" />
<?php
$this->endWidget();
?>
