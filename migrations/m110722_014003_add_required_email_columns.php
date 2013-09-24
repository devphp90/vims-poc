<?php

class m110722_014003_add_required_email_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn('supplier', 'email_string', 'string');
		$this->addColumn('supplier', 'email_sender', 'string');
	}

	public function down()
	{
		echo "m110722_014003_add_required_email_columns does not support migration down.\n";
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