<?php

class m120203_104451_change_user_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user` ADD `deleted` BOOLEAN NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `user` DROP `deleted`");
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