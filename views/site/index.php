<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if (Yii::app()->user->isGuest) { ?>
<p>To begin, please <?php echo CHtml::link("Login", array('site/Login')); ?></p>
<?php } else { ?>
<p>
	<?php echo CHtml::link("Manage Action Table", array('/Action')); ?><br />
	<?php echo CHtml::link("Manage Action Type Table", array('/ActionType')); ?><br />
	<?php echo CHtml::link("Manage Alert Table", array('/Alert')); ?><br />
	<?php echo CHtml::link("Manage Alert Template Table", array('/AlertTemplate')); ?><br />
	<?php echo CHtml::link("Manage External SKU Table", array('/External')); ?><br />
	<?php echo CHtml::link("Manage Import Log Table", array('/ImportLog')); ?><br />
	<?php echo CHtml::link("Manage Import Statistics Table", array('/ImportStats')); ?><br />
	<?php echo CHtml::link("Manage Import Status Type Table", array('/ImportSttsType')); ?><br />
	<?php echo CHtml::link("Manage Import File Type Table", array('/ImportFileType')); ?><br />
	<?php echo CHtml::link("Manage Log Table", array('/Log')); ?><br />
	<?php echo CHtml::link("Manage Markup Table", array('/Markup')); ?><br />
	<?php echo CHtml::link("Manage Markup Type Table", array('/MarkupType')); ?><br />
	<?php echo CHtml::link("Manage Mode Table", array('/Mode')); ?><br />
	<?php echo CHtml::link("Manage Mode Type Table", array('/ModeType')); ?><br />
	<?php echo CHtml::link("Manage Multi-Inventory Table", array('/MultiInventory')); ?><br />
	<?php echo CHtml::link("Manage Multi-Warehouse Table", array('/MultiWarehouse')); ?><br />
	<?php echo CHtml::link("Manage Promotion Table", array('/Promotion')); ?><br />
	<?php echo CHtml::link("Manage Promotion Type Table", array('/PromoType')); ?><br />
	<?php echo CHtml::link("Manage Rule Table", array('/Rule')); ?><br />
	<?php echo CHtml::link("Manage Rule Group Table", array('/RuleGroup')); ?><br />
	<?php echo CHtml::link("Manage Setting Table", array('/Setting')); ?><br />
	<?php echo CHtml::link("Manage Supplier Catalog Table", array('/SupCatalog')); ?><br />
	<?php echo CHtml::link("Manage Supplier Column Map Table", array('/SupColMap')); ?><br />
	<?php echo CHtml::link("Manage Supplier Contact Table", array('/SupContact')); ?><br />
	<?php echo CHtml::link("Manage Supplier Exception Table", array('/SupException')); ?><br />
	<?php echo CHtml::link("Manage Supplier Fee Table", array('/SupFee')); ?><br />
	<?php echo CHtml::link("Manage Supplier Fee Type Table", array('/SupFeeType')); ?><br />
	<?php echo CHtml::link("Manage Supplier Import Info Table", array('/SupImportInfo')); ?><br />
	<?php echo CHtml::link("Manage Supplier Item Map Table", array('/SupItemMap')); ?><br />
	<?php echo CHtml::link("Manage Supplier Item Track Table", array('/SupItemTrack')); ?><br />
	<?php echo CHtml::link("Manage Supplier Item Track Type Table", array('/SupItemTrackType')); ?><br />
	<?php echo CHtml::link("Manage Supplier Item Unmap Table", array('/SupItemUnmap')); ?><br />
	<?php echo CHtml::link("Manage Supplier Location Table", array('/SupLocation')); ?><br />
	<?php echo CHtml::link("Manage Supplier Extra Map Table", array('/SupMapExtra')); ?><br />
	<?php echo CHtml::link("Manage Supplier New Item Table", array('/SupNewItem')); ?><br />
	<?php echo CHtml::link("Manage Supplier Table", array('/Supplier')); ?><br />
	<?php echo CHtml::link("Manage Supplier Sheet Table", array('/SupSheet')); ?><br />
	<?php echo CHtml::link("Manage UBS Catalog Table", array('/UbsCatalog')); ?><br />
	<?php echo CHtml::link("Manage UBS Discontinue Table", array('/UbsDiscontinue')); ?><br />
	<?php echo CHtml::link("Manage UBS Inventory Table", array('/UbsInventory')); ?><br />
	<?php echo CHtml::link("Manage UBS Price Table", array('/UbsPrice')); ?><br />
	<?php echo CHtml::link("Manage UBS SKU Table", array('/UbsSku')); ?><br />
	<?php echo CHtml::link("Manage User Table", array('/User')); ?><br />
	<?php echo CHtml::link("Manage User Role Table", array('/Role')); ?><br />
</p>	
<?php } ?>
