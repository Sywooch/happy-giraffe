<?php

class m121031_095948_friends_index extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `friends` ADD INDEX (  `created` )");
	}

	public function down()
	{
		echo "m121031_095948_friends_index does not support migration down.\n";
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