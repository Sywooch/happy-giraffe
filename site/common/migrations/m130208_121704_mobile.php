<?php

class m130208_121704_mobile extends CDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE `mobile__communities_communities`;

            ALTER TABLE  `community__communities` ADD  `mobile_community_id` INT( 11 ) UNSIGNED NULL;

            ALTER TABLE  `community__communities` ADD INDEX (  `mobile_community_id` );

            ALTER TABLE  `community__communities` ADD FOREIGN KEY (  `mobile_community_id` ) REFERENCES  `hg_new`.`mobile__communities` (
            `id`
            ) ON DELETE CASCADE ON UPDATE CASCADE ;

            UPDATE `community__communities` SET `mobile_community_id` = '1' WHERE `community__communities`.`id` = 1; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 2; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 3; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 4; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 5; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 6; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 7; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 8; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 9; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 10; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '2' WHERE `community__communities`.`id` = 11; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 12; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 13; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '3' WHERE `community__communities`.`id` = 14; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 15; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 16; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 17; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '4' WHERE `community__communities`.`id` = 18; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '15' WHERE `community__communities`.`id` = 20; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '14' WHERE `community__communities`.`id` = 21; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '10' WHERE `community__communities`.`id` = 24; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '10' WHERE `community__communities`.`id` = 25; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '7' WHERE `community__communities`.`id` = 26; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '8' WHERE `community__communities`.`id` = 28; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '12' WHERE `community__communities`.`id` = 29; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '13' WHERE `community__communities`.`id` = 30; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '6' WHERE `community__communities`.`id` = 31; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '5' WHERE `community__communities`.`id` = 32; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '9' WHERE `community__communities`.`id` = 34; UPDATE `hg_new`.`community__communities` SET `mobile_community_id` = '11' WHERE `community__communities`.`id` = 35;
        ");
	}

	public function down()
	{
		echo "m130208_121704_mobile does not support migration down.\n";
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