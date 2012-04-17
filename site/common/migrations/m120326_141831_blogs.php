<?php

class m120326_141831_blogs extends CDbMigration
{
	public function up()
	{
        $this->execute("DELETE FROM `happy_giraffe`.`club_community` WHERE `club_community`.`id` = 999999");
        $this->execute("ALTER TABLE `club_community_rubric` CHANGE `community_id` `community_id` INT( 11 ) UNSIGNED NULL ");
	}

	public function down()
	{
		echo "m120326_141831_blogs does not support migration down.\n";
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