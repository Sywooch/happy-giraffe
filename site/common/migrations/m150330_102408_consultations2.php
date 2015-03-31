<?php

class m150330_102408_consultations2 extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
		DROP TABLE consultation__answers;
		DROP TABLE consultation__consultants;
		DROP TABLE consultation__questions;
		DROP TABLE consultation__consultations;

		CREATE TABLE `consultation__consultations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `consultation__consultants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `consultationId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`),
  KEY `userId` (`userId`),
  CONSTRAINT `consultation__consultants_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `consultation__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `consultation__questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `consultationId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `url` varchar(255) NOT NULL,
  `created` int(8) unsigned NOT NULL,
  `updated` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`),
  KEY `userId` (`userId`),
  CONSTRAINT `consultation__questions_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `consultation__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `consultation__questions_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

CREATE TABLE `consultation__answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionId` int(11) unsigned NOT NULL,
  `consultantId` int(11) unsigned NOT NULL,
  `text` text,
  `created` int(8) unsigned NOT NULL,
  `updated` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionId` (`questionId`),
  KEY `consultantId` (`consultantId`),
  CONSTRAINT `consultation__answers_ibfk_3` FOREIGN KEY (`questionId`) REFERENCES `consultation__questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `consultation__answers_ibfk_2` FOREIGN KEY (`consultantId`) REFERENCES `consultation__consultants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m150330_102408_consultations2 does not support migration down.\n";
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