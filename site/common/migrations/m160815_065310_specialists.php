<?php

class m160815_065310_specialists extends CDbMigration
{
	public function up()
	{
		$this->execute("DROP TABLE IF EXISTS `specialists__profiles`;

CREATE TABLE `specialists__profiles` (
  `id` int(11) unsigned NOT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  CONSTRAINT `specialists__profiles_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("DROP TABLE IF EXISTS `specialists__specializations`;

CREATE TABLE `specialists__specializations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("DROP TABLE IF EXISTS `specialists__profiles_specializations`;

CREATE TABLE `specialists__profiles_specializations` (
  `profileId` int(11) unsigned NOT NULL,
  `specializationId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`profileId`,`specializationId`),
  KEY `specializationId` (`specializationId`),
  CONSTRAINT `specialists__profiles_specializations_ibfk_2` FOREIGN KEY (`specializationId`) REFERENCES `specialists__specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `specialists__profiles_specializations_ibfk_1` FOREIGN KEY (`profileId`) REFERENCES `specialists__profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("ALTER TABLE `users` ADD `specialistInfo` TEXT  NULL  AFTER `specInfo`;");
	}

	public function down()
	{
		echo "m160815_065310_specialists does not support migration down.\n";
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