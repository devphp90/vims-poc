<style type="text/css">

.hr-darkred
{height:4px; color:darkred;
	
}

.auto-style1 {

	color: #800000;

}

.auto-style5 {
	background-color: #FFFFFF;
}

.auto-style6 {
	background-color: #FFFF00;
}

.auto-style7 {
	background-color: #FFFFFF;
	color: #800000;
}

.auto-style8 {
	background-color: #FF0000;
}

</style>
<span class="auto-style1">
<p><strong>Global Cancel Rate</strong></p>
</span>
<?php echo CHtml::link("Global Limit and Threshold Levels",array('/systemInfo/admin'))?>
<br>
Cancel Rate
<a id="qa_section"></a>
<hr>

<span class="auto-style1">
<p><strong>Quality Assurance (QA) and Data Integrity (DI) Rules</strong></p>
</span>


<?php echo CHtml::link("QA % Rules, Global Level",array('/updateQaGlobal/admin'))?>
<br/><br/>
<?php echo CHtml::link("QA % Rules, Supplier Level",array('/updateQaSupplier/admin'))?>
<a id="buff_section"></a>
<br>

<hr><span class="auto-style1"><strong>QTY Buffer Rules, Supplier Items, 
vValues calculations.</strong></span><br>

<?php echo CHtml::link("Global Level, QTY gBuffer Rule",array('/importBufferRule/admin'));?>
<br>
<span class="auto-style5">Global level, applied 1st</span>.
Used to "buffer" Supplier reported sQTY.  Applies to all Suppliers and all Supplier Items (BIG TABLE).<br>
Over-ridden by Supplier level rule, if any.
<br><br>

<?php echo CHtml::link("Supplier Level, QTY sBuffer Rule",array('/ImportSupBufferRule/admin'));?>
<br>
<span class="auto-style5">Supplier level, applied 2nd, over-rides Global Rules</span>. 
Used to "buffer" Supplier reported sQTY for all of their Supplier Items.<br>
Over-ridden by Item rule, if any.
<br><br>

<?php echo CHtml::link("Item Level, QTY iBuffer Rule",array('/ImportSupItemBufferRule/admin'));?>
<br>
<span class="auto-style5">Item level, applied 3rd, over-rides Supplier 
level Rules</span>. Used to "buffer" Supplier reported sQTY for an individual Item.
<br><br>
<hr>
<span class="auto-style1"><strong>QTY Buffer Rules, Multiple Suppliers scenario, affects UBS Items 
calculations.</strong></span><br>
<?php echo CHtml::link("Multiple Suppliers Buffer Rule",array('/importMultisupBufferRule/admin'));?>
<br>Multiple Suppliers Buffer Rule, apply mBuffer to Combined QTY (cQTY) at UBS Item level.
<br>
<br>
<hr>
<span class="auto-style1"><strong>QTY Buffer Rules, Difference between Supplier 
Cost, affects UBS Items 
calculations.</strong></span><br>
<?php echo CHtml::link("Difference In Cost Percentage Rule",array('/ubsPercentageRule/admin'));?>
<br>
If multiple Suppliers, and a Supplier's Price differs too much<br>from Primary Supplier, exclude that Supplier's 
sQOH from combined cQOH.

<br>

<hr><span class="auto-style1"><strong>Price MarkUp Rules, affects UBS Sell Price in 
UBS Items calculations.</strong></span>
<br>

<?php echo CHtml::link("Sell Price Markup Rule, Global Level",array('/importMarkup/admin'));?>
<br>
Used to determine UBS Sell Price.
<br><br>

<?php echo CHtml::link("Sell Price Markup Rule, Supplier Level",array('/importSupMarkup/admin'));?>
<br>
Used to determine UBS Item Sell Price. Includes "Break" MAP rules at Supplier level.<br>
This level over-rides global level rule.
<br><br>

<hr>
<strong><span class="auto-style7">User Transactions, OverRide Rules</span></strong><br><?php echo CHtml::link("User OverRide Supplier Price, at Supplier Level",array('/importSupOverride/admin'));?><br>
<span class="auto-style6">[POC v.2]</span> Used to OverRide VIMS sPrice (UBS cost) at the <strong>
<span class="auto-style6">Supplier</span></strong> level. Applies to All Items, 
a $ from/to range, a Group, or one Item.<br>
Example: Supplier extends special promo pricing (10% discount) to all Items for a range 
of Prices and dates.<br>This adjusts vPrice to arrive at uPrice.<br>uPrice, if 
present, is then used to determine UBS Item values and designations such as 
Primary Supplier.<br>uValues are more reliable (more certain) and take priority over vValues.
(POC for the ALL field)
<br>

<br>
<?php echo CHtml::link("User OverRide Supplier Qty, at Supplier Item Level",array('/importSupItemOverride/admin'));?>
<br>
<span class="auto-style8"><span class="auto-style6">[POC v.2, as of 7/19]</span></span> Used to OverRide VIMS sQTY at the <strong>
<span class="auto-style6">Supplier Item/span></strong> level. Applies to one item per rule.<br>
Example: Supplier guarantees a special promo QTY for an Item for a range of dates. 
(WIP)
<br>

