<?php

class m110713_203504_add_suppliers extends CDbMigration
{
	public function up()
	{
		$suppliers = array (
		  0 => 
		  array (
		    'name' => 'JBOutman',
		    'uri' => 'https://www.jboutman.com/inventoryfeed.asp',
		    'username' => 'tracking@unbeatablesale.com',
		    'password' => 'knife',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'HTTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'InventoryFeed.xls',
		    'file_type' => 'XLS',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 7,
		    'sku' => 0,
		    'upc' => 12,
		    'item_name' => 2,
		    'quantity' => 4,
		    'price' => 11,
		    'delimiter' => '	',
		  ),
		  1 => 
		  array (
		    'name' => 'AAA',
		    'uri' => 'http://partners.allaboutautographsinc.com/spreadsheets/datafeed.xls',
		    'username' => '',
		    'password' => '',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'HTTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'datafeed.xls',
		    'file_type' => 'XLS',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 0,
		    'upc' => 0,
		    'item_name' => 2,
		    'quantity' => 9,
		    'price' => 7,
		    'delimiter' => '	',
		  ),
		  2 => 
		  array (
		    'name' => 'CFD',
		    'uri' => 'ftp://cfd.coop/',
		    'username' => 'cfddatafeed     ',
		    'password' => 'CFDsince1935',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'FTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'CFD_Catalog_Data.csv',
		    'file_type' => 'CSV',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 0,
		    'upc' => 2,
		    'item_name' => 11,
		    'quantity' => 3,
		    'price' => 4,
		    'delimiter' => '	',
		  ),
		  3 => 
		  array (
		    'name' => 'Leadertech',
		    'uri' => '',
		    'username' => '',
		    'password' => '',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'EMAIL',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'Leadertech.xlsx',
		    'file_type' => 'XLSX',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 7,
		    'mname' => 6,
		    'sku' => 0,
		    'upc' => 11,
		    'item_name' => 8,
		    'quantity' => 10,
		    'price' => 9,
		    'delimiter' => '	',
		  ),
		  4 => 
		  array (
		    'name' => 'LogoChairs',
		    'uri' => 'ftp2.logochairs.com',
		    'username' => 'logo',
		    'password' => 'logochair',
		    'info_type' => 'INV',
		    'connection_type' => 'FTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'Inventory available for Dot Coms.csv',
		    'file_type' => 'CSV',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 0,
		    'upc' => 6,
		    'item_name' => 2,
		    'quantity' => 3,
		    'price' => 0,
		    'delimiter' => '	',
		  ),
		  5 => 
		  array (
		    'name' => 'ComIntPPE',
		    'uri' => 'ftp://ftp.commerceinterface.com/in/update_inventory/',
		    'username' => '',
		    'password' => '',
		    'info_type' => 'INV',
		    'connection_type' => 'FTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'update_inventory-8612-PPE WHOLESALE.csv',
		    'file_type' => 'CSV',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 0,
		    'upc' => 0,
		    'item_name' => 0,
		    'quantity' => 2,
		    'price' => 0,
		    'delimiter' => '	',
		  ),
		  6 => 
		  array (
		    'name' => 'EageTools',
		    'uri' => '',
		    'username' => '',
		    'password' => '',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'EMAIL',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => '{Date} Inventory & Pricing Reports.xls',
		    'file_type' => 'XLS',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 6,
		    'sku' => 0,
		    'upc' => 5,
		    'item_name' => 4,
		    'quantity' => 3,
		    'price' => 2,
		    'delimiter' => '	',
		  ),
		  7 => 
		  array (
		    'name' => 'PlumIslandSilver',
		    'uri' => 'http://www.plumislandsilver.com/pguides.csv',
		    'username' => '',
		    'password' => '',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'HTTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'pguides.csv',
		    'file_type' => 'CSV',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 11,
		    'upc' => 0,
		    'item_name' => 3,
		    'quantity' => 6,
		    'price' => 14,
		    'delimiter' => '	',
		  ),
		  8 => 
		  array (
		    'name' => 'Triarch',
		    'uri' => 'ftp.unbeatablesale.biz',
		    'username' => 'Triarch International',
		    'password' => '10763',
		    'info_type' => 'INV',
		    'connection_type' => 'FTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'triarch.csv',
		    'file_type' => 'CSV',
		    'skip_rows' => 0,
		    'header' => 0,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 0,
		    'upc' => 0,
		    'item_name' => 0,
		    'quantity' => 2,
		    'price' => 0,
		    'delimiter' => '	',
		  ),
		  9 => 
		  array (
		    'name' => 'Vickerman',
		    'uri' => 'ftp://ftp.vickerman.com/ecomm/',
		    'username' => 'vickerman',
		    'password' => 'Christmas1!',
		    'info_type' => 'INVPRC',
		    'connection_type' => 'FTP',
		    'is_zipped' => 'FALSE',
		    'zip_name' => '',
		    'file_name' => 'InventoryStatusFull.xls',
		    'file_type' => 'XLS',
		    'skip_rows' => 1,
		    'header' => 1,
		    'mpn' => 1,
		    'mname' => 0,
		    'sku' => 0,
		    'upc' => 0,
		    'item_name' => 2,
		    'quantity' => 7,
		    'price' => 5,
		    'delimiter' => '	',
		  ),
		);
		
		// Add them
		foreach($suppliers as $r) {
			echo "Adding " . $r['name'] . "\n";
			$this->insert('suppliers', $r);
		}
	}

	public function down()
	{
		echo "m110713_203504_add_suppliers does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}