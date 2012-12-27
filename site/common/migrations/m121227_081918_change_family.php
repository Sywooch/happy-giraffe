<?php

class m121227_081918_change_family extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `user__users_babies` CHANGE  `sex`  `sex` TINYINT( 1 ) NULL DEFAULT  '2';");
	}

	public function down()
	{
		echo "m121227_081918_change_family does not support migration down.\n";
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