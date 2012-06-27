<?php

class m120627_124335_chenge_cooke_decoration extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__decorations` ADD `description` VARCHAR( 200 ) NOT NULL AFTER `title`");
        $this->execute("UPDATE `cook__decorations` set description = title; UPDATE `cook__decorations` set title = '';");
        $this->execute("update album__photos set title = '' where id in (SELECT photo_id FROM `cook__decorations`)");
	}

	public function down()
	{
		echo "m120627_124335_chenge_cooke_decoration does not support migration down.\n";
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