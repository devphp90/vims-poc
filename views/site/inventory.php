



<style type="text/css">

.hr-darkred
{height:4px; color:darkred;

}

.auto-style1 {

	color: #800000;

}

.auto-style13 {
	color: #000000;
}

.auto-style14 {
	background-color: #FF0000;
	color: #000000;
}

.auto-style15 {
	background-color: #00FF00;
}

</style>
<?php $this->pageTitle=Yii::app()->name; ?>

<?php if (Yii::app()->user->isGuest) { ?>

<p>To begin, please <?php echo CHtml::link("Login", array('site/Login')); ?></p>

<p>Last update: 11/19/2013, 11:00 AM PST</p>

<?php } else { ?>










<span class="auto-style1"><strong>System Status and Notes</strong></span><br>
<br><strong>11/19/2013:</strong><br>VIMS is under construction POC and alpha1.<br><span class="auto-style13">Parts of VIMS are 
in progress, incomplete, or </span>
<span class="auto-style14">DOWN</span>.<br>Auto Import/Update is
<span class="auto-style15">
UP</span>.<br><br>NOTES:<br><br>Only Chrome browser is supported at this time.<br>
<br>For Email Attachment Supplier:&nbsp; <a href="mailto:vims.ubs@gmail.com">vims.ubs@gmail.com</a><br>
<br>For Copy n Paste Supplier, the practical limit is &lt;1000 rows<br><br>
WIP, 11/18-11/24/2013:<br>All User Stories and Business Requirements are in POC 
or
alpha1.<br>POC quick testing (on going).<br>UBS
is testing business rules, logic, and calculations.&nbsp; Primary Supplier
designation, Rules, Price and Qty calcs.
<br/><br/><hr>

<?php
echo CHtml::link("UBS Items Seed Routine", Yii::app()->createUrl('/ubsItemsSync'));
?>
<br/>
UBS Items seed
(for AXEO use only)
<br/><br/>
<?php
echo CHtml::link("Supplier Items Seed Routine", Yii::app()->createUrl('supItemsSync'));
//echo CHtml::link("Supplier Items Import and Sync", Yii::app()->createUrl('/supInventory/importSeedSheet'));
?>
<br/>
Supplier Items Seed Routine
(for AXEO use only)
<br><br>
<?php } ?>
<?php echo CHtml::link("Seed UBS Items",'/seed/ubsItems',array('target'=>'_blank'))?>
<br><a href="http://vims.axeo.net/index.php/seed/ubsItems">http://vims.axeo.net/index.php/seed/ubsItems</a> 
(for AXEO use only)
<br><br>

<a target="_blank" href="http://vimsln.axeo.net/pHpmYaDmIn/">Database</a>
<br>
View DB with phpMyAdmin.
<br>
<br>
<?php echo CHtml::link("Supplier Failed Import Reasons", array('/supFailedImportReasons/admin'));?>
<br><br>
Users:
<?php echo CHtml::link("Manage Users",array('/User/admin'));?>
<hr>


<br>

<hr><span class="auto-style1"><strong>Support tables, look-up lists, pick lists, categories, types</strong></span><br><br>

<?php echo CHtml::link("Manage Supplier Import Routine and Column Map (VIMS 4.0)", array('/importRoutine/admin')); ?>
<br><br>

<?php echo CHtml::link("Manage Import Data Transfer Types (ftp, http, VIMS 4.0)", array('/importMethod/admin')); ?>
<br><br><br>

<?php echo CHtml::link("Manage Import File Types (csv, txt, VIMS 4.0)", array('/importFileType/admin')); ?>
<br><br>

<?php echo CHtml::link("Manage Import Routine Servers", array('/ImportRoutineServer/admin')); ?>
<br><br>
<?php echo CHtml::link("Manage System Info",array('/systemInfo/admin'))?>

<br/><br/>
<?php echo CHtml::link("Manage QA Info(Global)",array('/updateQaGlobal/admin'))?>
<br/><br/>
<?php echo CHtml::link("Manage QA Info(Supplier)",array('/updateQaSupplier/admin'))?>
<br><br/>
VIMS 3.0 Data Tables
<?php echo CHtml::link('VIMS 3.0 data tables',array('/site/index'));
?>
<hr><br>

<br>
<?php echo CHtml::link("System Info",array('/systemInfo/admin'))?>
<br>
Cancel rate, email notification addresses ...
<br/>


<span class="auto-style1"><strong>Reports</strong></span><br>




<?php echo CHtml::link("Database",'/pHpmYaDmIn',array('target'=>'_blank'))?>
</body></html>