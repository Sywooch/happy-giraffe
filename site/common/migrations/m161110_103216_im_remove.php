<?php

class m161110_103216_im_remove extends CDbMigration
{
	public function up()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS=0;");
		$this->execute("DROP TABLE im__deleted_messages;");
		$this->execute("DROP TABLE im__dialog_deleted;");
		$this->execute("DROP TABLE im__dialog_users;");
		$this->execute("DROP TABLE im__dialogs;");
		$this->execute("DROP TABLE im__messages;");
		$this->execute("SET FOREIGN_KEY_CHECKS=1;");
	}

	public function down()
	{
		echo "m161110_103216_im_remove does not support migration down.\n";
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