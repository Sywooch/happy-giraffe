<?php

class m120210_082503_change_users_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user` ADD `register_date` DATETIME NOT NULL ,
        ADD `login_date` DATETIME NOT NULL ");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `user`
		  DROP `register_date`,
		  DROP `login_date`;");
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