<?php

class m120625_145307_remove_method extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` DROP `method` ");
	}

	public function down()
	{
		echo "m120625_145307_remove_method does not support migration down.\n";
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