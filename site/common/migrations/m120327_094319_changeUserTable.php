<?php

class m120327_094319_changeUserTable extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user` ADD `avatar` INT( 10 ) NULL DEFAULT NULL AFTER `pic_small`");
	}

	public function down()
	{
		echo "m120327_094319_changeUserTable does not support migration down.\n";
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