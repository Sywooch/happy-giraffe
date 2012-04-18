<?php

class m120417_113528_rename_interest_columns extends CDbMigration
{
	public function up()
	{
        $this->renameColumn('interest__categories', 'name', 'title');
        $this->renameColumn('interest__interests', 'name', 'title');
	}

	public function down()
	{
		echo "m120417_113528_rename_interest_columns does not support migration down.\n";
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