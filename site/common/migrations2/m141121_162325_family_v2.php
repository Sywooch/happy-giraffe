<?php

class m141121_162325_family_v2 extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `family__families`;

CREATE TABLE `family__families` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `adultsRelationshipStatus` enum('friends','engaged','married') DEFAULT NULL,
  `created` int(8) unsigned NOT NULL,
  `updated` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("DROP TABLE IF EXISTS `family__members`;

CREATE TABLE `family__members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('adult','child','planning','waiting') DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `gender` tinyint(1) unsigned DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `description` text NOT NULL,
  `userId` int(11) unsigned DEFAULT NULL,
  `familyId` int(11) unsigned NOT NULL,
  `created` int(8) unsigned NOT NULL,
  `updated` int(8) unsigned NOT NULL,
  `removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `planningWhen` enum('soon','next3Years') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `familyId` (`familyId`),
  CONSTRAINT `family__members_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `family__members_ibfk_2` FOREIGN KEY (`familyId`) REFERENCES `family__families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m141121_162325_family_v2 does not support migration down.\n";
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