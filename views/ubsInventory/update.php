<?php
$this->breadcrumbs=array(
	'Ubs Inventory'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage', 'url'=>array('admin')),
);
?>

<h1>Update UBS Items <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

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
</script>
