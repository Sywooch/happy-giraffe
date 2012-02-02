<?php

class m120202_062024_change_user_baby_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user_baby` ADD `sex` BOOLEAN NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `user_baby` DROP `sex`");
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