
<head>
<style type="text/css">

.auto-style4 {

	background-color: #FFFF00;

}

.auto-style13 {
	background-color: #00FF00;
}

h3
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:115%;
	page-break-after:avoid;
	font-size:14.0pt;
	font-family:"Cambria","serif";
	color:black;
	}
.auto-style14 {
	font-weight: normal;
}
.auto-style16 {
	background-color: #FFFFFF;
}
.auto-style17 {
	color: #333333;
	background-color: #FFFFFF;
}
.auto-style18 {
	color: #333333;
}

</style>
</head>

<?php
$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About (info is continuously added and changed)</h1>
<p>System Name: VIMS<br>Problem Frame: 
Information Problem<br>Pattern: Inventory Management, virtual with User 
over-rides<br>Computing Platform: LAMP, Yii Framework, ODBC to MSSQL, Browser-based, 
VPS<br>Methodology: Agile/X</p>

<hr>

<p><strong>User Stories (User words are in quotes, Developer edits in brackets):</strong></p>
<p><span class="auto-style14">“The goal of this program is to replace the legacy 
inventory pricing program that currently manages UBS inventory AND 
Supplier costs (written in Access with SQL linked tables).”</span></p>
<p><span class="auto-style14">"The program needs to be automated as much as 
possible. It will constantly run (24/7) doing its job of updating inventory and 
pricing."</span></p>
<p>"The typical use case would be generally automated imports (on a schedule by 
supplier) of inventory information that would be made available to us by our 
suppliers."</p>
<p><span class="auto-style14">"There are other inventory suppliers that only 
update us via email [<span class="auto-style17">data in table or list form 
embedded in the email, not a file attachment</span>], so we cannot import the 
inventory sheet.<span class="auto-style16">"</span></span></p>
<p>"The data that we receive and extract from the suppliers needs to be used 
optimally to give us all available information."</p>
<p>"So if we receive just inventory and not pricing we will use just that 
information. For example if a supplier does not give us a quantity but instead 
indicates YES/NO for inventory we will use that, however if the quantity is 
available then we will use the quantity. If the supplier also provides our cost 
price we will extract that price for use in the program. Some supplier will give 
us two separate sheets one for Inventory and on for pricing."</p>
<p><span class="auto-style14">"In order to recognize and determine what each 
field from each supplier means in relation to our inventory structure, we’ll 
need a tool for an end user to correctly MAP each of the fields in the supplier 
sheet to our associated inventory and pricing fields (mapping tool). "</span></p>
<p>[UBS Items could have and do have the same MPN.]</p>
<p>"Supplier says this item needs to be DISCO ASAP (even though it is on the 
sheets). Perhaps Unbeatable is no longer approved to carry that brand."</p>
<p><span class="auto-style14">"In some cases expected inventory sheets will not 
be available for some reason and therefore we need to decide what steps we will 
take to update or not update inventory."</span></p>
<p>"There will be [<span class="auto-style18">Quality Assurance, QA</span>] 
global rules and specific rules. For example all suppliers will have a rule that 
if there is a 50% or greater change to the number of items on the inventory 
sheet (“item count”) then this sheet will not update anything and it will be 
ignored. Specific suppliers may have a rule that is different (35% of the 
items)."</p>
<p>"If we have not received inventory for a supplier in a while and we need to 
decide what to do with the item that was in stock from this supplier before. Of 
course if the item was available from another supplier then this supplier will 
remain the primary supplier. A typical rule that we use is to BO the item for 5 
days (perhaps it was a fluke and the item will be on tomorrow’s sheet) if the 
item does not appear on 5 consecutive inventory sheets then the item status is 
changed to Discontinued. The reason why we need this is because we need to move 
this item to discontinued status so that we no longer request inventory from the 
supplier."</p>
<p><span class="auto-style14">"Combined inventory from more than one supplier – 
meaning supplier A and Supplier B offer us the same exact item, needs to be 
handled in a few ways."</span></p>
<p>"Each item that we sell has a primary supplier that is determined based upon 
rules such as cost price, inventory level, cancel rates by supplier, number of 
ship days (leadtime) by supplier (i.e. this supplier has it in stock and is at 
the lowest cost)."</p>
<p><span class="auto-style14">"The program will also need to consider the 
LOCATION of the inventory."</span></p>
<p><span class="auto-style14">"The program needs to give a user the ability to 
set [Price] markups."</span></p>
<p>"Although MAP (the manufactures minimum allowed selling price) is something 
that we adhere to in most cases, there are some exceptions. For example: if we 
see that most competitors are not keeping to the MAP. We would like the program 
to give us the option of Overiding MAP (“Break Map”) on the SUPPLIER level."</p>
<p><span class="auto-style14">"The program needs to give the user the ability to 
assign special promotional pricing for a set period of time. This will override 
the standard pricing and inventory. For example if a vendor gives us a special 
promotional price on an item for the month of December, or sets aside 100 units 
for us to use in a special promotion."<br><br>"Supplier says this item needs to 
be DISCO ASAP (even though it is on the sheets). Perhaps Unbeatable is no longer 
approved to carry that brand. This overRides there vSheet."<br><br></span>
"Reports of all stages."<span class="auto-style14"> </span><o:p><br><br><br></o:p>
</p>

<hr>

<p><strong>Abbreviations, acronyms, short hand, definitions:</strong></p>
<p>VIMS = virtual inventory management system<br>CRUD = 
Create (add, new), Read (view), Update (edit, change), Delete records<br>Manage 
= CRUD<br>POC = 
proof of concept<br></p>
<p>SKU = Stock Keeping Unit, an item for sale<br>SKU# = SKU value, the unique 
identifier<br>VSKU# = VIMS SKU value;&nbsp; this value is virtual or made-up by 
UBS<br>VQOH = VIMS QOH;&nbsp; Supplier QOH "buffered"<br>Item = In VIMS, a product for 
sale by either UBS, or a Supplier.&nbsp; Also called a SKU.<br>UPC = Universal Product Code</p>
<p>MAP = Minimum Allowed Price, Minimum Advertised Price, Minimum Resale Price, 
Minimum Sell Price<br>MSRP =
<span class="product-description-bullets">Manufacturer Suggested Retail Price</span></p>
<p>MPN = Manufacturer Part Number<br>QOH = Qty on hand<br>Sup = Supplier<br>DS = drop shipper;&nbsp; UBS 
suppliers drop ship<br></p>
<p>Supplier Update Sheet data transfer type = connection, 
location, delivery, access, method</p>
<hr>
<p><strong>Notes:</strong></p>
<p>Inventory is "virtual". UBS takes orders from Customers, then Suppliers drop-ship directly to Customer.<br>UBS does not take actual possession of the products.</p><p>VIMS imports Supplier inventory sheets and 
updates UBS virtual inventory items.</p>
<p>UBS constructs their own SKUs. When a new supplier is picked-up by UBS, the 
inventory system is manually initialized with the supplier's product 
catalog.&nbsp; VIMS updates a subset of fields with periodic inventory sheets 
received from the supplier.</p>
<p>WIP</p>
<p>Filter Builder (in POC).<br>Bulk 
Actions feature in various data grids (POC).<br>Supplier Setup, multiple 
warehouses (POC).<br>Sheet date/time stamp over-ride feature at Supplier level 
(POC).<br><span class="auto-style16">Filter Builder, with MultiSelect col 
options, and Bulk Select and Update page (in POC as of 6/18).</span><br>InBound/OutBound data 
routines using VIMS Import/Update pattern (in POC).<br>Cancel Rate rules (in POC).<br>Charting/Graphing 
(in POC).<br>Partial/Quick Update from File, Small Medium Suppliers (to be treated by User 
like an email Supplier).<br>David's UI/UX list (WIP).<br>Sheet with appended today's date (WIP).<br>Sheet with scheduled time 
of day for Import/Date (WIP).</p>
<p class="auto-style16">
Sheet2 new Supplier setup features (WIP, 7/15; POC, 7/22).</p>
<p><span class="auto-style16">User Transactions, OverRide Price ALL Rule (v.2 in POC as of 
7/15).</span></p>
<p>DashBoard and Reports (WIP, wireframe and POC).</p>
<p class="auto-style16">Checkers column width, set by User (in design, POC, 7/21)</p>
<p>UI/UX features - Fixed Header in various grids; InLine Editing in various 
grids, especially Rules (alpha1)</p>
<p class="auto-style16">Checkers - matching feature is vSKU, MPN+UPC, MPN+MfgName, UPC, MPN (POC)</p>
<p class="auto-style16">Checkers - if last 10 chars of UPC match, then positive match, handles 
leading zero prob (POC, now reverting)</p>
<p class="auto-style16">
Email Suppliers, sheet info embedded in email (in design, WIP, 
7/20, now in POC)</p>
<p class="auto-style16">
Nav Step Suppliers, clicks and links to nav to sheet (in design, WIP, 
7/23, now in POC, not integrated yet for I/U)</p>
<p>&nbsp;</p>
<p><span class="auto-style16">Supplier Setup, Sheet Retrieve and Mapping, now 3rd 
iteration i.3. Similar to ftp client combined with Excel Import 
(in POC).</span><br class="auto-style16"><span class="auto-style16">Sheet Preview (in POC), Browse to Sheet (in POC), re-work HTTP section to setup 
a wider variety of HTTP Suppliers</span></p>
<hr>
<strong>Data Models and Work Flows:</strong>
<br><br>
<?php
$image = CHtml::image(Yii::app()->request->baseUrl.'/images/VIMS-data-org-chart_small.PNG','',array('class'=>'auto-style1','height'=>51,'width'=>100,'xthumbnail-orig-image'=>'VIMS-data-org-chart.PNG'));

echo CHtml::link($image,Yii::app()->request->baseUrl.'/images/VIMS-data-org-chart.PNG');
?>
<br><br>
<hr>
<p><strong>Base Case:</strong></p>
<p>built in part to test sheet import routines<br>one supplier; example: Supplier #1,<br>one import delivery method 
at a time (aka 
access, or data transfer method); example: ftp<br>one file type for update sheet 
(aka format); example: csv<br>supplier provides one update sheet format with 
qty-on-hand and/or price<br>one supplier (and one supplier item) for each UBS SKU<br></p>
<hr>
<p><strong>Assumptions:</strong></p>
<p>The import delivery method, file type, column positions, and column names stay the same 
for every supplier update sheet.<br>A "match" relies primarily on the Supplier 
SKU value in the UBS Inventory file.<br>The terms, "product", "item", "inventory", and "SKU" 
are used interchangeably.<br></p>
<hr>
<p><strong>Comments:</strong></p>
<p>Item # identifies the theoretical physical (and atomic) product. A can of 
Coke. A 12-pack of Coke is the actual item for sale and therefore has a SKU 
assigned to it. So, Coke Item #=COKE, and the SKU=COKE-12PK.</p>
<p>SKU stands for "Stock Keeping Unit," and is conveniently pronounced "skew." A 
SKU is a number or string of alpha and numeric characters that uniquely identify 
a product. For this reason, SKUs are often called part numbers, product numbers, 
and product identifiers. SKUs may be a universal number such as a UPC code or 
supplier part number or may be a unique identifier used by a specific a store or 
online retailer. For example, one company may use the 10 character identifier 
supplied by the manufacturer as the SKU of an external hard drive. Another 
company may use a proprietary 6-digit number as the SKU to identify the part. 
Many retailers use their own SKU numbers to label products so they can track 
their inventory using their own custom database system.</p>
<p>SKUs can identify variants of products. A 12-pack of Coke; common properties 
such as color, collection, size ...<br>SKUs are not always associated with 
actual physical items, but are more appropriately billable entities. Extended 
warranties, delivery fees, and installation fees are not physical, but have SKUs 
because they are billable. </p>
<p>An inventory sheet may introduce a new product 
not in the original catalog and therefore no matching UBS SKU.</p>
<p>&nbsp;</p>

-----------------
archives

<br>
<strong>Import/Update Log</strong> (<span class="auto-style4">alpha</span>):
<?php echo CHtml::link('Manage Import and Update Log',array('/logs/admin'));
?>

<br><span class="auto-style13">________________________________________________________<br></span><br>

<strong>Supplier Setup v.2</strong> (<span class="auto-style4">alpha</span>):
<?php echo CHtml::link('Manage Supplier Setup',array('/wizards/admin'));
?>

<br>
<br/>
<strong><br>Supplier Setup v.3 (multi-sheet)</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('Manage Supplier Setup (multi-sheet)',array('/tabs/admin'));
?>
<br>

<br><span class="auto-style13">Nav Step Suppliers POC (</span><span class="auto-style14">POC</span><span class="auto-style13">):</span>
<?php echo CHtml::link('Nav Step Suppliers POC',array('/supplier/navSteps'));
?>
<br>

Supplier Import/Update Routines (alpha):   
Manual Upload sheet, Update Now sheet. (Step 3, New Supplier Setup)
<p>&nbsp;</p>

<br><strong><span class="auto-style13">Email Suppliers POC (</span><span class="auto-style14">POC</span><span class="auto-style13">):</span>
<?php echo CHtml::link('Email Suppliers POC',array('/emailSuppliers/create'));
?>

<br>

<br>


<strong>DashBoard</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('DashBoard',array('/site/dashboard'));?>

<br/><br>
<strong>Inbound/Outbound Data</strong> (<span class="auto-style4">POC</span>):
<?php echo CHtml::link('Inbound/Outbound Data',array('/site/datafeed'));?>
<br>
<br>
<strong>Import/Update Process</strong> (<span class="auto-style4">alpha1</span>):
<?php echo CHtml::link('Start/Stop, Import and Update Process',array('/importRoutine/routinecontrol'));
?>

<br>
<span class="auto-style13">
Supplier Master File (inactive):
<?php echo CHtml::link('Manage Supplier Master File',array('/supplier/admin'));
?>
 (Step 1, New Supplier Setup)
</span> 
<br class="auto-style13">
<span class="auto-style13">
Supplier Warehouses (inactive):
<?php echo CHtml::link('Manage Supplier Warehouses',array('/supWarehouse/admin'));
?>
&nbsp;(Step 2, New Supplier Setup)</span> 
<br>


<br>

<span class="auto-style13">

Supplier New Items and Link to UBS Item, 
"Checkers" (inactive):</span> 
<?php echo CHtml::link('Manage Supplier New Items and Link to UBS Item',array('/supNewItem/newItemLink'));
?>
<br>


<br>
<span class="auto-style13">Manage No Match Items (POC):</span>
<?php echo CHtml::link('Manage No Match Items',array('/supNewItem/noMatchItem'));
?>
<br>
<br>
<span class="auto-style13">Manage Dropped Items (POC):</span>
<?php echo CHtml::link('Manage Dropped Items',array('/supInventory/dropItem'));
?>
<br>
<br>
<span class="auto-style13">
<strong>Manage Imported Items</strong> (</span><span class="auto-style14">POC</span><span class="auto-style13">):
<?php echo CHtml::link('Manage Imported Items',array('/supNewItem/importedItem'));
?>
</span>
<br class="auto-style13">
<br class="auto-style13"><span class="auto-style13">Supplier New Items (</span><span class="auto-style14">POC</span><span class="auto-style13">):</span>
<?php echo CHtml::link('Manage Supplier "New" Items.',array('/supNewItem/admin'));
?>
<br>

Import/Update Routine


Auto Import: 
Turn process on and off.
Global start and stop for all Suppliers.
Suppliers with Update status set to Yes in Supplier Import Routine will Update.
This process is running server-side, so you do not need to be logged-in to VIMS for it to run.
If the server is off line, goes down, or is unavailable, this process will not work.
It is possible, although unlikely, that this process could halt on its own.

<?php echo CHtml::link('Manage Import/Update Log',array('/logs/admin'));?>

<br><br>

<?php echo CHtml::link('Manage Import/Update Logs(new)',array('/logs/admin'));?>

<br><br>
<?php echo CHtml::link("Manage Import Routine Servers", array('/ImportRoutineServer/admin')); ?>

<br><br>



