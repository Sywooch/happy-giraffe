<?php

class m130213_164024_mobile_binds extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE `community__communities` SET `mobile_community_id` = '1' WHERE `community__communities`.`id` = 1;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 2;
UPDATE `community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 3;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 4;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 5;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 6;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 7;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 8;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 9;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 10;
UPDATE `community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 11;
UPDATE `community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 12;
UPDATE `community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 13;
UPDATE `community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 14;
UPDATE `community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 15;
UPDATE `community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 16;
UPDATE `community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 17;
UPDATE `community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 18;
UPDATE `community__communities` SET `mobile_community_id` = '15' WHERE `community__communities`.`id` = 20;
UPDATE `community__communities` SET `mobile_community_id` = '14' WHERE `community__communities`.`id` = 21;
UPDATE `community__communities` SET `mobile_community_id` = '10' WHERE `community__communities`.`id` = 24;
UPDATE `community__communities` SET `mobile_community_id` = '10' WHERE `community__communities`.`id` = 25;
UPDATE `community__communities` SET `mobile_community_id` = '7' WHERE `community__communities`.`id` = 26;
UPDATE `community__communities` SET `mobile_community_id` = '8' WHERE `community__communities`.`id` = 28;
UPDATE `community__communities` SET `mobile_community_id` = '12' WHERE `community__communities`.`id` = 29;
UPDATE `community__communities` SET `mobile_community_id` = '13' WHERE `community__communities`.`id` = 30;
UPDATE `community__communities` SET `mobile_community_id` = '6' WHERE `community__communities`.`id` = 31;
UPDATE `community__communities` SET `mobile_community_id` = '5' WHERE `community__communities`.`id` = 32;
UPDATE `community__communities` SET `mobile_community_id` = '9' WHERE `community__communities`.`id` = 34;
UPDATE `community__communities` SET `mobile_community_id` = '11' WHERE `community__communities`.`id` = 35;
");
	}

	public function down()
	{
		echo "m130213_164024_mobile_binds does not support migration down.\n";
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