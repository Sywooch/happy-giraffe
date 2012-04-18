<?php

class m120417_100229_rename_auth extends CDbMigration
{
	public function up()
	{
        $this->renameTable('auth_assignment','auth__assignments');
        $this->renameTable('auth_item','auth__items');
        $this->renameTable('auth_item_child','auth__items_childs');
	}

	public function down()
	{
		echo "m120417_100229_rename_auth does not support migration down.\n";
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