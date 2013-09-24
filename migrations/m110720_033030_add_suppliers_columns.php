<?php

class m110720_033030_add_suppliers_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn('suppliers', 'is_started', "tinyint(1) NOT NULL default '0'");
		$this->addColumn('suppliers', 'last_run', "int(10) NOT NULL default '0'");
		$this->addColumn('suppliers', 'next_run', "int(10) NOT NULL default '0'");
		$this->addColumn('suppliers', 'run_every', "char(10) NOT NULL default '1d'");
	}

	public function down()
	{
		echo "m110720_033030_add_suppliers_columns does not support migration down.\n";
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