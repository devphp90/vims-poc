<script src="http://atum.com.tw/perfectum/js/excanvas.js"></script>
<script src="http://atum.com.tw/perfectum/js/jquery.flot.min.js"></script>
<script src="http://atum.com.tw/perfectum/js/jquery.flot.pie.min.js"></script>
<script src="http://atum.com.tw/perfectum/js/jquery.flot.stack.js"></script>
<script src="http://atum.com.tw/perfectum/js/jquery.flot.resize.min.js"></script>
<?php
$this->breadcrumbs = array(
    'Dashboard',
);
?>
<style type="text/css">

    .tile {
        width: 200px;
        float: left;
        padding: 10px 40px 10px 40px;
        margin-top: 10px;
        margin-bottom: 10px;
        margin-right: 10px;
        background-color: #D9EDF7;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
    }

    .tile h1 {
        margin-bottom: 8px;
        font-size: 1.2em;
        line-height: 1;
        letter-spacing: 1px;
        color: black;
    }

    .tile p {
        font-size: 18px;
        font-weight: 200;
        line-height: 20px;
        color: black;
    }


</style>
</head>

<body>

    <br>

    <div class="row">
        <a href="<?php echo $this->createUrl('/tabs/dashboard')?>">
            <div class="tile" style="min-height:110px;">
                <h1>
                    Supplier Status<br>
                    
                    <br/>Chg Active/Inactive
					<br>
					<br/>
                    <span style="color:#ff0000"># Inactive = <?= Supplier::model()->count('active = 0'); ?></span>
                    


                </h1>
            </div>
        </a>
       <a href="<?php echo $this->createUrl('/tabs/dashboard')?>">
            <div class="tile" style="min-height:110px;">
                <h1>
                     Supplier Items<br> 
					 <br>
					 Chg Active/Inactive<br/>
                    
                    
					
                    
                    <br/>


                </h1>
            </div>
        </a>

        <a href="<?php echo $this->createUrl('/supNewItem/noMatch')?>">
            <div class="tile" style="min-height:110px;">
                <h1>Supplier New Items
                    <br/>
                    <br/>"No Match"
                    <br/>Export to Excel
                    <br/></h1>

            </div>
        </a>
        <a href="<?php echo $this->createUrl('/tabs/admin', array('type' => 'dashboard'))?>">
            <div class="tile" style="min-height:110px;">
                <h1>Process Email 
				<br>List Suppliers
                    <br/>
                    <br/>
                 
                    <br/></h1>
            </div>
        </a>

    </div>


    <div class="row">

        <a href="<?php echo $this->createUrl('/tabs/supplierSetupStatus')?>">
            <div class="tile" style="min-height:110px;">
                <h1>Supplier Setup
                    <br/>Status List
                    <br/>
					<br/>
                    <br/>
	    <span style=" color:#ff0000; position: relative;">
                    # of Incomplete = <?php
            echo Supplier::model()->count('setup_status = "I"');
            ?>
		</span>
                    
                </h1>


            </div>
        </a>
        
        
        <a href="<?php echo $this->createUrl("tabsImportLog/failImportAndUpdate")?>">
            <div class="tile" style="min-height:110px;">
                <h1>Failed Imports
                    <br/>and Updates

                    <br/>
					 <br/>
                    <br/>
                <span style=" color:#ff0000; position: relative;">
                    # of Suppliers = <?php
                    echo TabsImportLog::countFailImportUpdate();
                    ?>
                </span>
                   
                </h1>

            </div>
        </a>
		 <a href="<?php echo $this->createUrl('/tabs/supplierNotScheduled');?>">
            <div class="tile" style="min-height:110px;">
                <h1>Suppliers
                    <br/>Non-Scheduled
                    <br/>
					  <br/>
                    <br>
	   <span style=" color:#ff0000; position: relative;">
                    # of Suppliers = <?php
           $supplier = new Supplier('search');
           $supplier->unsetAttributes();
           echo $supplier->searchNotScheduled()->totalItemCount;
           ?>
                </span>
                  
                </h1>

            </div>
        </a>
		 <a href="<?php echo $this->createUrl('tabs/supitemstatus')?>">
            <div class="tile" style="min-height:110px;">
                <h1>
                    Supplier Stock
                    <br/>Status Summary
                    <br/>
                    <br/>
                    <br/>
                </h1>
            </div>
        </a>
    </div>


    <div class="row">
        <a href="<?php echo $this->createUrl('/ImportWarnitemQty/admin')?>">
            <div class="tile" style="min-height:110px;">
                <h1>Qty Item Warnings
                    <br/>Report
                    <br/>
                    <br/>
                    <br/></h1>

            </div>
        </a>
        <a href="<?php echo $this->createUrl('/ImportWarnitemPrice/admin')?>">
            <div class="tile" style="min-height:110px;">
                <h1>Price Item Warnings
                    <br/>Report
                    <br/>
                    <br/>
                    <br/></h1>

            </div>
        </a>
		<!--
        <a href="<?php echo $this->createUrl('/tabs/supitemstatus')?>">
            <div class="tile" style="min-height:110px;">
                <h1>Supplier Items
                    <br/>Stock Status
                    <br/>
                    <br/>
                    <br/>(report, POC)</h1>

            </div>
        </a>
		-->
        <a href="<?php echo $this->createUrl('/importVsheet/notchanged')?>">
            <div class="tile" style="min-height:110px;">
                <h1>Supplier Items
                    <br/>with No QTY Change
                    <br/>
                    <br/>
                    <br/></h1>


            </div>
        </a>
		
		 <a href="<?php echo $this->createUrl('/supInventory/admin')?>">
            <div class="tile" style="min-height:110px;">
                <h1>
                    Supplier Items 
                    <br/>Master List
                    <br/>
                    <br/>
                    <br/>
                </h1>
            </div>
        </a>
		 
    </div>

  

    <hr>

    <div class="row">
        <div class="span3"><?php $this->widget('SuppliersWidget'); ?></div>
        <div class="span3"><?php $this->widget('SupplierItemsWidget'); ?></div>
        <div class="span3"><?php $this->widget('ImportLogsWidget'); ?></div>
        <div class="span3"><?php $this->widget('UpdateLogsWidget'); ?></div>
    </div>
    <div style="clear:both;"></div>
<!--
    <br/>
    # of Open tickets in VIMS: (wireframe)
    <br/>
    # of Suppliers IU today: <?php //echo TabsImportLog::model()->count("create_time like '" . date('Y-m-d') . "%'")?>
    <br/>
    # of Suppliers Items IU today: <?php //echo SupInventory::model()->count("last_update like '" . date('Y-m-d') . "%'")?>
   -->

   <br/>
    <hr>
    <div id="stats-chart" class="center" style="height:300px"></div>
    <script type="text/javascript">
        var data1 = [
            [10, 10],
            [20, 15],
            [30, 22],
            [40, 18],
            [50, 50],
            [60, 10],
            [70, 10],
            [80, 15],
            [90, 22],
            [100, 18],
            [110, 50],
            [120, 10],
            [130, 10],
            [140, 15],
            [150, 22],
            [160, 18],
            [170, 50],
            [180, 10],
            [190, 10],
            [200, 15],
            [210, 22],
            [220, 18],
            [230, 50],
            [240, 10]
        ];

        var data2 =<?php
        $time = strtotime(date('Y-m-d'));
        $array = array();
        $array2 = array();
        $a = 0;

        for ($i = 5; $i >= 1; $i--) {
            //$array2[] = array(date("Y-m-d",$time-($i*3600)),$i);
        }

        for ($i = 1; $i <= 24; $i++) {
            $array2[] = array($i * 10, rand() % 20);
        }



        echo json_encode($array2);
        ?>;
        $(document).ready(function () {
            console.log(data1);
            console.log(data2);
            $.plot(
                    $("#stats-chart"),
                    [
                        { data:data2, lines:{ show:true} }
                    ]
            );
        });
    </script>
    <div class="row">
        <a href="#<?php // echo $this->createUrl('/supNewItem/supChecker')?>">
            <div class="tile" style="min-height:110px;" title="Currently Not In Use" onclick="alert('Currently Not In Use')">
                <h1 style="color: gray">Supplier New Items
                    <br/>"Checkers"
                    <br/>
                    <br/>
                    <br/>(manage, POC)
                </h1>

            </div>
        </a>


        <a href="<?php echo $this->createUrl('/tabsImportLog/failRoutine')?>">
            <div class="tile" style="min-height:110px">
                <h1 style="color: #a9a9a9">Failed Imports
                    <br/>
                    <br>
	   <span style="color:gray;  font-weight: bold;"># of Suppliers = <?php

           $model = new TabsImportLog('search');
           echo  $model->failsearch()->totalItemCount;

           ?></span>
                    <br>
                    <br/>(manage, POC)
                </h1>

            </div>
        </a>

        <!--<a href="<?php echo $this->createUrl('/tabsUpdateLog/failRoutine')?>">-->
        <div class="tile" style="min-height:110px;">
            <h1 style="color:gray">Failed Updates
                <br/>Report
                <br/><br/>
                <br/>(POC)</h1>

        </div>
        <!--</a>-->
		<a href="<?php echo $this->createUrl('/tabs/supplierSetupStatus')?>">
            <div class="tile" style="min-height:110px;">
                <h1 style="color: #a9a9a9">Supplier Items BO
                    <br/>Manage
                    <br/>
                    <br/>

                    <br/>(wireframe)</h1>
            </div>
        </a>
    </div>
	
	<div class="row">
	<a href="<?php echo $this->createUrl('/supInventory/dashboard')?>">
            <div class="tile" style="min-height:110px;">
                <h1 style="color: #a9a9a9">Supplier Items sQTY
                    <br/>Manage
                    <br/>
                    <br/>
                    <br/>(wireframe)
                </h1>

            </div>
        </a>
		
		  <a href="#<?php //echo $this->createUrl('/importRoutine/dashboard')?>">
            <div class="tile" style="min-height:110px;">
                <h1 style="color: #a9a9a9">Manual Sheet <br> Import/Update
                    <br/><br/>
                    <br/></h1>

            </div>
        </a>
	</div>
