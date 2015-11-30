<?php

class m151109_145536_qa extends CDbMigration
{
	public function up()
	{
      $this->execute("SET foreign_key_checks = 0;");
      $this->execute("CREATE TABLE `qa__consultations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;");
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
  CONSTRAINT `qa__consultations_consultants_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `qa__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      $this->execute("CREATE TABLE `qa__categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;");
      $this->execute("CREATE TABLE `qa__questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `sendNotifications` tinyint(1) unsigned NOT NULL,
  `categoryId` int(11) unsigned DEFAULT NULL,
  `consultationId` int(11) unsigned DEFAULT NULL,
  `authorId` int(11) unsigned NOT NULL,
  `dtimeCreate` int(10) unsigned DEFAULT NULL,
  `dtimeUpdate` int(10) unsigned DEFAULT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `isRemoved` tinyint(1) unsigned NOT NULL,
  `rating` float(10,5) unsigned NOT NULL,
  `answersCount` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  KEY `authorId` (`authorId`),
  KEY `dtimeCreate` (`dtimeCreate`),
  KEY `consultationId` (`consultationId`),
  CONSTRAINT `qa__questions_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `qa__categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `qa__questions_ibfk_2` FOREIGN KEY (`consultationId`) REFERENCES `qa__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20059 DEFAULT CHARSET=utf8;");
      $this->execute("CREATE TABLE `qa__answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `questionId` int(11) unsigned NOT NULL,
  `authorId` int(11) unsigned NOT NULL,
  `dtimeCreate` int(10) unsigned DEFAULT NULL,
  `dtimeUpdate` int(10) unsigned DEFAULT NULL,
  `isRemoved` int(1) unsigned NOT NULL,
  `votesCount` smallint(5) unsigned NOT NULL,
  `isBest` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionId` (`questionId`),
  KEY `authorId` (`authorId`),
  KEY `votesCount` (`votesCount`),
  CONSTRAINT `qa__answers_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `qa__questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49128 DEFAULT CHARSET=utf8;");
      $this->execute("CREATE TABLE `qa__answers_votes` (
  `answerId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `dtimeCreate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`answerId`,`userId`),
  CONSTRAINT `qa__answers_votes_ibfk_1` FOREIGN KEY (`answerId`) REFERENCES `qa__answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      $this->execute("CREATE TABLE `qa__users_rating` (
  `userId` int(11) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `questionsCount` smallint(5) unsigned NOT NULL,
  `answersCount` smallint(5) unsigned NOT NULL,
  `rating` float(10,5) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`type`),
  KEY `rating` (`rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      $this->execute("SET foreign_key_checks = 1;");
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