<?php

class m110722_024947_add_more_email_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn('supplier', 'email_subject', 'string');
	}

	public function down()
	{
		echo "m110722_024947_add_more_email_columns does not support migration down.\n";
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