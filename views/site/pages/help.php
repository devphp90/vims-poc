<?php

$this->breadcrumbs=array(
	'Help',
);
?>
<head>
<style type="text/css">
.auto-style1 {
	color: #800000;
}

.auto-style4 {

	background-color: #FFFF00;

}

.auto-style2 {

	color: #0000FF;

}

.auto-style7 {
	color: #800000;
	font-size: x-large;
}

.auto-style10 {
	color: #FF0000;
}
.auto-style12 {
	color: #FFFFFF;
}

.auto-style11 {
	background-color: #FFFFFF;
}
.auto-style9 {
	color: #008000;
}
.auto-style8 {
	background-color: #008080;
}

</style>
</head>

<p class="auto-style7">Help page is under construction ...</p>
<p class="auto-style1"><strong>Please report bugs and make any 
suggestions or comments by email (axeo@axeo.com) or vmail (800-535-7524).</strong>&nbsp; Thanks.</p>
<p class="auto-style1"><span class="auto-style4">Work flow issue:</span>&nbsp; Until further 
notice, if you change the Import &amp; Update frequency for a Supplier to one that 
is not already in use, you need to re-Start the Auto Import routine.&nbsp; For 
example, if Accutech is set to 1 hour and you change it to 3 hours, a re-Start 
is NOT needed since a&nbsp; 3-hour Import freq is already in use somewhere.&nbsp; 
If though, you changed the freq to some unusual value such as 18 minutes (not 
already in use), a re-Start is required.&nbsp; Note that if you make the change 
and don't re-Start, the Supplier records in question will NOT be correct.</p>
<p class="auto-style1"><span class="auto-style1"><strong>System Outline - workflow and dataflow</strong></span><br>
<br><strong>Supplier Master File (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('Manage Supplier Setup (multi-sheet)',array('/tabs/admin'));
?>

<br>
</strong> Supplier Setup
<br>step1: supp name and info<br>step2: sheet name, location, and retrieval 
method <br>step3: map sSheet(s) to 
vSheet using import remote/local and drag n drop<br>step4: assign 
vSKU<br>step5: map warehouses if more than 1 <strong>
<br>
<br>
Import, Mod1 (<span class="auto-style4">POC</span>)<br></strong> get Supplier sheets,<br>step1: import current sSheets using file location and 
frequency from Mod1; get sheets on our servers!
<br><strong><br>

Create vSheet, Mod2 (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('View vSheets',array('/importVsheet/admin'));
?>
<br/>
<?php echo CHtml::link('View Last vSheets',array('/importVsheetLast/admin'));
?>
</strong> create standard UBS vSheet 
using sSheets and mapping from Mod1;<br>convert sSheets to UBS standard form (BIG TABLE);&nbsp; combine sheets when 
multi-sheet Supplier<br><strong><br>Update, Mod3 (</strong><span class="auto-style4"><strong>POC</strong></span><strong>):</strong><br>
Update Supplier Items and UBS Items; apply 
QA, buffer and adjustment rules<br>step 1: QA vSheet, if FAIL, de-activate 
Supplier, BO Items<br>step 2: QA vSheet Items, if WARNING, write to Items 
Warning log,&nbsp; then Update Supplier Items&nbsp;&nbsp; <br>step 3: apply 
front end inputs such as Cancellation Rate, and Open Orders<br>step 4: update Supplier Items table<br>step 
5: if New Items, then Update Checkers table<br>step 6: update UBS Items table</p>
<p class="auto-style1">Required system fields <span class="auto-style10"><strong>*</strong></span> 
:&nbsp; Fields marked with a <span class="auto-style7">&nbsp;<span class="auto-style12">red</span>
</span><span class="auto-style11">&nbsp;asterisk</span> are required by VIMS to 
Create or Save a record.<br>Required Import/Update fields <span class="auto-style9"><strong>*</strong></span> 
:&nbsp; Menu items, forms, tabs, sections and fields marked with a
<span class="auto-style8">&nbsp;<span class="auto-style12">green</span> </span>
<span class="auto-style11">&nbsp;asterisk</span> are required for the 
Import/Update process to work.<br><br>The email address for Import/Update by 
email is <a href="mailto:test@vims.axeo.net">test@vims.axeo.net</a>.</p>
<p class="auto-style1">&nbsp;</p>
<p class="auto-style1">&nbsp;</p>
<p class="auto-style1"><strong>UBS Items</strong></p>
<p>A UBS Item is top-level in VIMS and 
"virtual". A UBS Item can have 

multiple Suppliers.<br>Most values can be over-ridden by User.</p>
<p>A UBS Item must be on file before a Supplier Item can be added and linked.</p>
<p>cQOH = combined QOH; when there are multiple suppliers</p>
<p># of Suppliers is used in QOH adjustment rules</p>
<p>mBuffer is a multi-supplier adjustment to QOH</p>
<p>multiSup QOH is the adjusted QOH for all suppliers after Diff Cost % Rule is 
applied</p>
<p>If Mark Up Sale Price is &lt; MAP, and Break MAP rule = N, then Sale Price = MAP</p>
<p>If Supplier Cost differs too much from Primary Supplier Cost, exclude that 
Supplier's QOH from combined QOH.</p>
<p class="auto-style1"><strong>Primary Supplier</strong> has a Cancel Rate &lt;x%, 
has vQOH (after buffer), and the lowest price.<br><strong>Sale 
Price</strong> is based on Markup Rules.<br><strong>vQOH</strong> at this data level is combined by Supplier(s) 
and buffered.<br><strong>Supplier Price</strong> is an average of all Suppliers with vQOH.</p>
<p class="auto-style1">&nbsp;</p>
<p class="auto-style1"><strong>Supplier Items</strong></p>
<p>Supplier Items (the BIG TABLE) and Warehouse Records.<br>User manages 
Supplier Item records manually, and links the Supplier Item record (child) to 
the appropriate UBS Item record (parent).<br>A UBS Item can be provided by 
multiple suppliers. There is a one-to-many, or parent-child relationship between 
UBS Items and linked Supplier Items.</p>
<p>A Supplier Item must be on file before related Warehouse QOH records can be 
created.</p>
<p>&nbsp;</p>
<p><strong>sQOH</strong> = QOH reported by Supplier via Update sheets. sQOH is 
combined by Warehouse.<br>Click "detail" in the data grid to see breakdown by 
Warehouse.<br><br><strong>bQOH</strong> = sQOH - Buffer amount from Buffer 
Rules. Buffer rules are not cumulative, lowest level applies first.<br><br>
<strong>Open Orders</strong> comes from front end and adjusts bQOH.<br>Open 
Orders now lives as a field in Supplier Item table and is managed by User.<br>
<br><strong>vQOH</strong> (virtual QOH) = sQOH - Buffer - Open Orders.</p>
<p>From Update Sheets, VIMS makes periodic changes to inventory level fields - 
sQOH and price.<br>sQOH is the value reported by Supplier.&nbsp; "We can only 
know what we know".<br>

bQOH is qty-on-hand after Buffer Rules are applied to sQOH.<br>
vQOH = bQOH - Open Orders.<br>iBuffer = Item buffer qty, sBuffer = Supplier 
buffer qty, uBuffer = Global buffer qty (aka, system, default, UBS)<br>Buffer 
rules are applied and over-ridden bottom-up. First at the Item level, then 
Supplier, and last Global. (POC 9/12)<br>Open 
Orders comes from StoneEdge.<br>Similar to the approach used in vSKU, we make-up 
a reliable, usable "virtual" QOH, vQOH.</p>
<p>&nbsp;</p>
<p class="auto-style1"><strong>InStock, BackOrder, Discontinued rules:</strong></p>
<p>If Item is on sheet, but QOH=”0” or “No”, then BO.<br>If Item is no longer on 
sheet, record date, and change status to BO.</p>
<p># of INSTOCK Items changes by x% for latest sheet.<br>Compare current sheet 
to last sheet, If number of items INSTOCK changes by &gt;= x%,&nbsp; then Log and don’t 
Update. </p>
<p>&nbsp;</p>
<hr>
<p>User manages a child record for each warehouse (including 
the QOH 

value).<br>A Supplier Item can have multiple warehouses.<br>QOH for a Supplier Item is 

summed-up by warehouse.<br>The Auto Import &amp; Update process updates Price at the Item record 

level and QOH at the Warehouse level.<br>At this time, <span class="auto-style4">

VIMS does not create Supplier Item records or Warehouse child records as part of 

the Mapping function.</span><br>User performs this task manually.
</p>
Step 2 in New Supplier Setup.
A Supplier parent record must 

be on file before child Supplier Item records can be created.<br>A 

Supplier parent record must be on file before a Supplier Import Routine can be 

created.<strong> </strong></p>
<p>&nbsp;</p>
<p class="auto-style1"><strong>Supplier Import/Update Routines</strong></p>
<p>Set Update Status field to Yes if the Supplier should Auto 

Update.<br>Set Frequency to every x hours, or every x days.<strong><br><br>Mapping:</strong> Map Update Sheet columns (or field names) to the Supplier Item 

table data structure.<br>Upload a sample Supplier Sheet and Fetch the column 

names to help with mapping.<br>A column from an Update Sheet that does NOT have 

a corresponding field in the Supplier Item table cannot be mapped.<br>Up to 6 
Warehouses can be mapped.&nbsp; The warehouse needs to be on file before it can 
be mapped.<br><br><strong>Matching: </strong>

VSKU (VIMS SKU#) is a made-up value.<br>VSKU is the unique indentifier for a 

Supplier Inventory Update Sheet row.<br>Ideally, Suppliers would provide a 

column containing their SKU#, but they do not always do so.<br>So, User "creates" 

and assigns a reliable, unique identifier for each Supplier Item -- VSKU.<br>In 

effect, creating a Supplier SKU# for each Supplier Item.<br>VSKU can be made-up of up to 3 

Supplier Update Sheet columns.<br>These fields may, but do not have to live in 

the Supplier Item file, only VSKU.<br>VSKU is used for matching Update Sheet 

rows to records in the Supplier Item file.<br>Examples: VSKU=Supplier SKU#; 

VSKU=MPN+UPC; VSKU=MPN+UPC+Qty Case Pack<br><br>


<span class="auto-style1"><strong>Supplier New Items</strong></span><br>

<?php echo CHtml::link('Manage Supplier "New" Items.',array('/supNewItem/admin'));

?>

<span class="auto-style2"></span><br>Update Sheet 

items that don't Match and appear to be possible New Items<br>are written here 

by VIMS.<br>At this time, <span class="auto-style4">VIMS does not migrate New 

Items to the main Supplier Items file.</span><br>User performs this task 

manually.&nbsp; Click "Accept" in the New Item grid to copy the record to 
Supplier Items table (BIG TABLE).<br></p>

------------------------------
archive Home page content

<strong><br>Setup Supplier</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('Manage Supplier Setup (multi-sheet)',array('/tabs/admin'));
?>

<br>
Mod1 - Supplier Setup
<br>&nbsp;&nbsp; step1: supp name and sheet info<br>&nbsp;&nbsp; step2: map sSheet(s) to 
vSheet using import remote/local and drag n drop<br>&nbsp;&nbsp; step3: assign 
vSKU<br>&nbsp;&nbsp; step4: map warehouses if more than 1
<br>
<br>
<strong>Get Sheets</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('Import Supplier Inventory Sheets',array('/importRoutine/importroutine'));
?>

<br>
Mod2 - Import Supplier sSheets<br>&nbsp;
step1: import current sSheets using file location and 
frequency from Mod1; get sheets on our servers!
<br><br>

<strong>Create vSheets</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('View vSheets',array('/importVsheet/admin'));
?>
<br/>
<?php echo CHtml::link('View Last vSheets',array('/importVsheetLast/admin'));
?>
<br>

Mod3 - Create UBS vSheet 
using sSheets and mapping from Mod1;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
convert sSheets to UBS standard form (BIG TABLE);&nbsp; combine sheets when 
multi-sheet Supplier<br><br>

<strong>Update</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('Update routine',array('/importRoutine/updateroutine'));
?>
<br>
Mod4 - Update Supplier Items and UBS Items; apply 
QA, buffer and adjustment rules<br>step 1: QA vSheet, if FAIL, de-activate 
Supplier, BO Items<br>step 2: QA vSheet Items, if WARNING, write to Items 
Warning log,&nbsp; then Update Supplier Items&nbsp;&nbsp; <br>step 3: apply 
front end inputs such as Cancellation Rate, and Open Orders<br>step 4: update Supplier Items table<br>step 
5: if New Items, then Update Checkers table<br>step 6: update UBS Items table<br>
<br>
<strong>Output</strong> (<span class="auto-style4">POC</span>):
<br>Mod5 - Output and reports <br>
&nbsp;<br>

<br/>
<?php echo CHtml::link('Manage Main Log',array('/tabsMainLog/admin'));
?>
<br/>
<?php echo CHtml::link('Manage Import Log',array('/tabsImportLog/admin'));
?>
<br>

<br>

<span class="auto-style13">
________________________________________________________</span><br><br><strong>UBS Items</strong> (<span class="auto-style4">alpha</span>):
<?php echo CHtml::link('Manage UBS Items (SKUs)',array('/UbsInventory/admin'));
?>
&nbsp;(Step 4, New Supplier Setup)
<br><br>


<strong>Supplier Items</strong>, 
"BIG TABLE" (<span class="auto-style4">alpha</span>):
<?php echo CHtml::link('Manage Supplier Items and Warehouse Child Records.',array('/supInventory/admin'));
?>
&nbsp;(Step 5, New Supplier Setup)<br>

<br>
<span class="auto-style13">
________________________________________________________</span><br>



<hr><span class="auto-style1"><strong>Minor tables, support tables</strong></span>

<br>

<br>
Supplier Master File:
<?php echo CHtml::link('Manage Supplier Master File',array('/supplier/admin'));
?>
<br>
<br>
Supplier Warehouses:
<?php echo CHtml::link('Manage Supplier Warehouses',array('/supWarehouse/admin'));
?>
<br>Enter supplier warehouses even if Supplier has only one location.

<br>