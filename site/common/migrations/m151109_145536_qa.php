<?php

class m151109_145536_qa extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `qa__consultations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `qa__consultations_consultants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `consultationId` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `userId` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`),
  KEY `userId` (`userId`),
  CONSTRAINT `qa__consultations_consultants_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `qa__consultations_consultants_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `qa__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `qa__categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `consultationId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`),
  CONSTRAINT `qa__categories_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `qa__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `qa__questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `sendNotifications` tinyint(1) unsigned NOT NULL,
  `categoryId` int(11) unsigned NOT NULL,
  `authorId` int(11) unsigned NOT NULL,
  `dtimeCreate` int(10) unsigned DEFAULT NULL,
  `dtimeUpdate` int(10) unsigned DEFAULT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  KEY `authorId` (`authorId`),
  KEY `dtimeCreate` (`dtimeCreate`),
  CONSTRAINT `qa__questions_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `qa__categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `qa__answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `questionId` int(11) unsigned NOT NULL,
  `authorId` int(11) unsigned NOT NULL,
  `dtimeCreate` int(10) unsigned DEFAULT NULL,
  `dtimeUpdate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m151109_145536_qa does not support migration down.\n";
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