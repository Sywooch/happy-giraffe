<?php

class m111227_045358_travel extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `happy_giraffe`.`club_community_travel` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`text` TEXT NOT NULL ,
`content_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `club_community_travel` ADD INDEX ( `content_id` ) ;



CREATE TABLE `happy_giraffe`.`club_community_travel_waypoint` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`city_id` INT( 11 ) UNSIGNED NOT NULL ,
`country_id` INT( 11 ) UNSIGNED NOT NULL ,
`travel_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `club_community_travel_waypoint` ADD INDEX ( `city_id` ) ;
ALTER TABLE `club_community_travel_waypoint` ADD INDEX ( `country_id` ) ;
ALTER TABLE `club_community_travel_waypoint` ADD INDEX ( `travel_id` ) ;



CREATE TABLE `happy_giraffe`.`club_community_travel_image` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`image` VARCHAR( 255 ) NOT NULL ,
`travel_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `club_community_travel_image` ADD INDEX ( `travel_id` ) ;

		");
	}

	public function down()
	{
		echo "m111227_045358_travel does not support migration down.\n";
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