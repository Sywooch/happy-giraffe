<?php

class m150227_081453_contest extends CDbMigration
{
	public function up()
	{
		$this->execute("DROP TABLE IF EXISTS `commentators__contests`;

CREATE TABLE `commentators__contests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

      $this->execute("DROP TABLE IF EXISTS `commentators__contests_participants`;

CREATE TABLE `commentators__contests_participants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `contestId` int(11) unsigned NOT NULL,
  `score` smallint(5) unsigned NOT NULL,
  `place` smallint(5) unsigned NOT NULL,
  `dtimeRegister` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `contestId` (`contestId`),
  CONSTRAINT `commentators__contests_participants_ibfk_2` FOREIGN KEY (`contestId`) REFERENCES `commentators__contests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commentators__contests_participants_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("DROP TABLE IF EXISTS `commentators__contests_comments`;

CREATE TABLE `commentators__contests_comments` (
  `commentId` int(11) unsigned NOT NULL,
  `participantId` int(11) unsigned NOT NULL,
  `counts` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`commentId`,`participantId`),
  KEY `participantId` (`participantId`),
  CONSTRAINT `commentators__contests_comments_ibfk_2` FOREIGN KEY (`participantId`) REFERENCES `commentators__contests_participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commentators__contests_comments_ibfk_1` FOREIGN KEY (`commentId`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m150227_081453_contest does not support migration down.\n";
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