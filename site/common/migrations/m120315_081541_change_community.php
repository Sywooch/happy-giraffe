<?php

class m120315_081541_change_community extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `club_community` CHANGE `position` `position` TINYINT( 2 ) UNSIGNED NOT NULL DEFAULT '0'");
        $this->execute("
            UPDATE `club_community` SET `position` = 1 WHERE `club_community`.`id` = 1;
            UPDATE `club_community` SET `position` = 2 WHERE `club_community`.`id` = 2;
            UPDATE `club_community` SET `position` = 3 WHERE `club_community`.`id` = 3;
            UPDATE `club_community` SET `position` = 4 WHERE `club_community`.`id` = 4;
            UPDATE `club_community` SET `position` = 5 WHERE `club_community`.`id` = 5;
            UPDATE `club_community` SET `position` = 6 WHERE `club_community`.`id` = 6;
            UPDATE `club_community` SET `position` = 7 WHERE `club_community`.`id` = 7;
            UPDATE `club_community` SET `position` = 8 WHERE `club_community`.`id` = 8;
            UPDATE `club_community` SET `position` = 9 WHERE `club_community`.`id` = 9;
            UPDATE `club_community` SET `position` = 10 WHERE `club_community`.`id` = 10;
            UPDATE `club_community` SET `position` = 11 WHERE `club_community`.`id` = 11;
            UPDATE `club_community` SET `position` = 12 WHERE `club_community`.`id` = 12;
            UPDATE `club_community` SET `position` = 14 WHERE `club_community`.`id` = 13;
            UPDATE `club_community` SET `position` = 13 WHERE `club_community`.`id` = 14;
            UPDATE `club_community` SET `position` = 15 WHERE `club_community`.`id` = 15;
            UPDATE `club_community` SET `position` = 16 WHERE `club_community`.`id` = 16;
            UPDATE `club_community` SET `position` = 17 WHERE `club_community`.`id` = 17;
            UPDATE `club_community` SET `position` = 18 WHERE `club_community`.`id` = 18;
            UPDATE `club_community` SET `position` = 33 WHERE `club_community`.`id` = 19;
            UPDATE `club_community` SET `position` = 35 WHERE `club_community`.`id` = 20;
            UPDATE `club_community` SET `position` = 34 WHERE `club_community`.`id` = 21;
            UPDATE `club_community` SET `position` = 24 WHERE `club_community`.`id` = 22;
            UPDATE `club_community` SET `position` = 25 WHERE `club_community`.`id` = 23;
            UPDATE `club_community` SET `position` = 29 WHERE `club_community`.`id` = 24;
            UPDATE `club_community` SET `position` = 30 WHERE `club_community`.`id` = 25;
            UPDATE `club_community` SET `position` = 26 WHERE `club_community`.`id` = 26;
            UPDATE `club_community` SET `position` = 31 WHERE `club_community`.`id` = 27;
            UPDATE `club_community` SET `position` = 27 WHERE `club_community`.`id` = 28;
            UPDATE `club_community` SET `position` = 21 WHERE `club_community`.`id` = 29;
            UPDATE `club_community` SET `position` = 22 WHERE `club_community`.`id` = 30;
            UPDATE `club_community` SET `position` = 19 WHERE `club_community`.`id` = 31;
            UPDATE `club_community` SET `position` = 20 WHERE `club_community`.`id` = 32;
            UPDATE `club_community` SET `position` = 23 WHERE `club_community`.`id` = 33;
            UPDATE `club_community` SET `position` = 28 WHERE `club_community`.`id` = 34;
            UPDATE `club_community` SET `position` = 32 WHERE `club_community`.`id` = 35;
            UPDATE `club_community` SET `position` = 255 WHERE `club_community`.`id` = 999999;
        ");

	}

	public function down()
	{
		echo "m120315_081541_change_community does not support migration down.\n";
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