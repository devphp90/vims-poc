
<head>
    <style type="text/css">
        .auto-style1 {
            background-color: #FFFF00;
        }
    </style>
</head>

<h2>Inbound and Outbound Data Feeds</h2>

<h4>UBS-to-VIMS</h4>
<strong>Supplier Open Orders </strong><br/>
<a href="<?php echo Yii::app()->createUrl('ubsOpenOrder') ?>">Supplier Open Orders</a>
<br/><br/>

<strong>UBS-VIMS Suppliers seed table</strong> <br>
<a href="<?php echo Yii::app()->createUrl('ubsSupplierSeed/index') ?>">UBS-VIMS Suppliers seed table</a><br><br>

<strong>UBS-VIMS Suppliers table</strong> <br/>
<a href="<?php echo Yii::app()->createUrl('ubsSupplier') ?>">UBS-VIMS Suppliers table</a><br><br>

<strong>UBS-VIMS Supplier Items seed table</strong> <br>
<a href="<?php echo Yii::app()->createUrl('ubsSupplierItemSeed') ?>">UBS-VIMS Supplier Items seed table</a>

<br/><br/>
<strong>Supplier Stats</strong> <br/>
<a href="<?php echo Yii::app()->createUrl('ubsSupplierStat') ?>">Supplier Stats</a>

<br/><br/>
<strong>UBS Control</strong> <br/>
<a href="<?php echo Yii::app()->createUrl('ubsControlTable') ?>">UBS Control</a>
<br><br>
<strong>UBS Sku Feed</strong> <br/>
<a href="<?php echo Yii::app()->createUrl('ubsSkuFeed') ?>">UBS Sku Feed</a> <br><br>

<strong>Product Status</strong> <br/>
<a href="<?php echo Yii::app()->createUrl('ubsProductStatus') ?>">Product Status</a> <br><br>
<hr/>
<h4>VIMS-to-UBS</h4>


<br>
<strong>Ubs Vims Ubs Products</strong><br>
<a href="<?php echo Yii::app()->createUrl('ubsVimsUbsProduct') ?>">Ubs Vims Ubs Products</a> <br><br>
<a href="<?php echo Yii::app()->createUrl('/ubsVimsSupProducts/admin') ?>">Ubs Vims Sup Products</a> <br><br>
<hr/>
<br>

<h5>DataFeeds v.4.2</h5>





<strong>UBS Items</strong>
<br/>
<?php echo CHtml::link('UBS Items INBOUND', array('/supplier/importBound')) ?>
<br/>
Direction: <span class="auto-style1">FrontEnd --&gt; VIMS</span>;&nbsp; When: Daily;&nbsp;&nbsp;How: FTP delta file?
<br/><br/>

<strong>Supplier Item Open Orders</strong>&nbsp;&nbsp;
<br/>
<?php echo CHtml::link('Open Orders INBOUND', array('/supInventory/OpenOrderInbound')) ?>
<br/>
Direction: <span class="auto-style1">FrontEnd --&gt; VIMS</span>;&nbsp; When: Live;&nbsp; 
How:&nbsp; ODBC to UBS created table(s);&nbsp; Note: view/table in VIMS currently serves  as data source 
<br/><br/>

<strong>Supplier Cancel Rate</strong>
<br/><?php echo CHtml::link('Supplier Cancel Rate INBOUND', array('/supplier/supStat')); ?>;
<br/><?php echo CHtml::link('Supplier Items Cancel Rate INBOUND', array('/supInventory/supStat')); ?> 
<br/>
Direction: 
<span class="auto-style1">FrontEnd --&gt; VIMS</span>;&nbsp; When: Daily;&nbsp; How:&nbsp; ODBC to UBS created table(s);&nbsp; 
Note: view/table in VIMS currently serves  as data source
<br/><br/>

<strong>UBS Items, QTY/Pricing</strong>
<br/><?php echo CHtml::link('QTY/Pricing OUTBOUND', array('/ubsInventory/ubsItemOutBound')); ?>  
<br/>
Direction: <span class="auto-style1">VIMS --&gt; FrontEnd</span>;&nbsp; When: Live;&nbsp; 
How: TBD;&nbsp; Note: report in VIMS currently serves  as data source
<br/><br/>

<strong>UBS Items, QTY/Pricing Expanded for Ordering</strong>
<br/><?php echo CHtml::link('QTY/Pricing Expanded for ordering, OUTBOUND', array('/ubsInventory/ubsItemOutBoundExpand')); ?>  
<br/>
Direction: <span class="auto-style1">VIMS --&gt; FrontEnd</span>;&nbsp; When: Live;&nbsp; 
How: TBD;&nbsp; Note: report in VIMS currently serves  as data source
<br/><br/>

<strong>Suppliers<br></strong>Direction: 
<span class="auto-style1">FrontEnd --&gt; VIMS</span>;&nbsp; When: Daily;&nbsp; How:&nbsp;TBD;&nbsp; 
Note: what is common Supplier ID?<br><br>

<strong>Supplier Items, New, NoMatch in Checkers<br></strong>Direction: 
<span class="auto-style1">VIMS --&gt; FrontEnd</span>, 
Kevin;&nbsp; When: TBD;&nbsp; 
How: TBD;&nbsp; Note: Kevin makes new SKUs and feedsback to VIMS
<br><br>


VIMS-to-SQLServer, ODBC Connection Test, this view/table resides on UBS SQLServer
<br/><?php echo CHtml::link('QTY/Sell Price update Outbound, Item Description update InBound', array('/ubsInventory/odbctest')); ?>  
<br/><br/>
