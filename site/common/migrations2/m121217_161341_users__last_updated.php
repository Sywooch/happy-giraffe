<?php

class m121217_161341_users__last_updated extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `users` ADD  `last_updated` TIMESTAMP NULL");
	}

	public function down()
	{
		echo "m121217_161341_users__last_updated does not support migration down.\n";
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