<?php

class m130426_081618_messaging__threads_updated extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `messaging__threads` ADD INDEX (  `updated` )");
	}

	public function down()
	{
		echo "m130426_081618_messaging__threads_updated does not support migration down.\n";
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