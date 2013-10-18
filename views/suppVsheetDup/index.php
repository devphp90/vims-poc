<?php
$this->breadcrumbs=array(
	'Supp Vsheet Dups',
);

$this->menu=array(
	array('label'=>'Create ','url'=>array('create')),
	array('label'=>'Manage ','url'=>array('admin')),
);
?>

<h1>Supp Vsheet Dups</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
