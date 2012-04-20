<?php

class m120417_101905_rename_bag_columns extends CDbMigration
{
	public function up()
	{
        $this->renameColumn('bag__categories','name','title');
        $this->renameColumn('bag__items','name','title');
	}

	public function down()
	{
		echo "m120417_101905_rename_bag_columns does not support migration down.\n";
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