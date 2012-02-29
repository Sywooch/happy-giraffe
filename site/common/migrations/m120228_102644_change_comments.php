<?php

class m120228_102644_change_comments extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comment` CHANGE `model` `entity` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        CHANGE `object_id` `entity_id` INT( 11 ) UNSIGNED NOT NULL ");
	}

	public function down()
	{
		echo "m120228_102644_change_comments does not support migration down.\n";
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