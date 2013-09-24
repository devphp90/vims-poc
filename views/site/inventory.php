



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
	background-color: #FFFF00;
	color: #000000;
}

.auto-style15 {
	background-color: #00FF00;
}

.auto-style16 {
	background-color: #FFFFFF;
}

.auto-style17 {
	background-color: #FF0000;
}

</style>
<?php $this->pageTitle=Yii::app()->name; ?>

<?php if (Yii::app()->user->isGuest) { ?>

<p>To begin, please <?php echo CHtml::link("Login", array('site/Login')); ?></p>

<p>Last update: 09/12/2013, 08:00 AM PST</p>

<?php } else { ?>










<span class="auto-style1"><strong>System Status and Notes</strong></span><br>
<br><strong>09/12/2013:</strong><br>VIMS is under construction and alpha1
testing.<br><span class="auto-style13">Parts of VIMS are </span>
<span class="auto-style14">DOWN</span>.&nbsp;Manual Import/Update
routine is UP.<br>Manual Update routine is UP.&nbsp;Auto Import/Update is
<span class="auto-style15">
<span class="auto-style17">DOWN</span></span>.<br>InBound/OutBound Data ODBC test is
<span class="auto-style17">DOWN</span>.<br><br>NOTE:&nbsp; Only Chrome browser is supported at this time.<br><br>
WIP, 9/09-9/15/2013:<br>All User Stories and Business Requirements are in
alpha1 unless otherwise noted below.<br>Alpha1 quick testing (on going).<br>UBS
is testing business rules, logic, and calculations.&nbsp; Primary Supplier
designation, Rules, Price and Qty calcs.<br>
<p class="auto-style16">UBS Items seed from CSV file</p>
<p class="auto-style16">Bradley seed and test</p>
<p>&nbsp;</p>
<br>
<?php
echo CHtml::link("UBS Items Seed Routine", Yii::app()->createUrl('/ubsItemsSync'));
?><br/><br/>
<?php
echo CHtml::link("Supplier Items Seed Routine - Bradley only", Yii::app()->createUrl('supItemsSync'));
//echo CHtml::link("Supplier Items Import and Sync", Yii::app()->createUrl('/supInventory/importSeedSheet'));
?>

<hr class="hr-darkred"><br><br>
<?php } ?>
<?php echo CHtml::link("Seed UBS Items",'/seed/ubsItems',array('target'=>'_blank'))?>
<br>http://vims.axeo.net/index.php/seed/ubsItems
<br><br>

<?php echo CHtml::link("Database",'/pHpmYaDmIn',array('target'=>'_blank'))?>
<br>
View DB with phpMyAdmin.
<br>


<hr class="hr-darkred"><span class="auto-style1"><strong>Menu: see top of page
main menu also.</strong></span><br>

<br>
<?php echo CHtml::link("Sup Failed Import Reasons", array('/supFailedImportReasons/admin'));?>
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