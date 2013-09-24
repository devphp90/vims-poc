<?php

class m110713_202737_add_supplier_tables extends CDbMigration
{
	public function up()
	{
		$this->createTable('suppliers', array(
			'id' => 'pk',
			'name' => 'string',
			'uri' => 'string',
			'username' => 'string',
			'password' => 'string',
			'info_type' => 'string',
			'connection_type' => "string NULL",
			'is_zipped' => "string",
			'zip_name' => 'string NULL',
			'file_name' => 'string',
			'file_type' => 'string',
			'skip_rows' => 'int',
			'header' => 'int',
			'mpn' => 'int',
			'mname' => 'int',
			'sku' => 'int',
			'upc' => 'int',
			'item_name' => 'int',
			'quantity' => 'int',
			'price' => 'int',
			'delimiter' => 'string',
		));
	}

	public function down()
	{
		echo "m110713_202737_add_supplier_tables does not support migration down.\n";
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