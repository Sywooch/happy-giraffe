<?php

class m150330_064943_consultations extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('manageConsultation', '1', 'Управление консультацией', 'return $params[\"consultation\"]->isConsultant(\\Yii::app()->user->id);', NULL);
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('answerQuestions', '0', 'Ответ на вопрос', NULL, NULL);
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageConsultation', 'answerQuestions');
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('user', 'manageConsultation');

CREATE TABLE `consultation__consultations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `consultation__answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionId` int(11) unsigned NOT NULL,
  `consultantId` int(11) unsigned NOT NULL,
  `text` text,
  `created` int(8) unsigned NOT NULL,
  `updated` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `consultation__consultants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `consultationId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `consultationId` (`consultationId`),
  KEY `userId` (`userId`),
  CONSTRAINT `consultation__consultants_ibfk_1` FOREIGN KEY (`consultationId`) REFERENCES `consultation__consultations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m150330_064943_consultations does not support migration down.\n";
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