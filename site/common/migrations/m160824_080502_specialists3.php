<?php

class m160824_080502_specialists3 extends CDbMigration
{
	public function up()
	{


		$this->execute("
		DROP TABLE IF EXISTS `specialists__profiles_specializations`;
		DROP TABLE IF EXISTS `specialists__profiles`;
		DROP TABLE IF EXISTS `specialists__groups`;
		DROP TABLE IF EXISTS `specialists__specializations`;
		DROP TABLE IF EXISTS `specialists__pediatrician_skips`;
		
		CREATE TABLE `specialists__pediatrician_skips` (
  `userId` int(11) unsigned NOT NULL,
  `questionId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`questionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		CREATE TABLE `specialists__groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `specialists__profiles` (
  `id` int(11) unsigned NOT NULL,
  `specialization` text NOT NULL,
  `courses` text NOT NULL,
  `education` text NOT NULL,
  `career` text NOT NULL,
  `experience` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `placeOfWork` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `specialists__profiles_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `specialists__specializations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `groupId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupId` (`groupId`),
  CONSTRAINT `specialists__specializations_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `specialists__groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		
CREATE TABLE `specialists__profiles_specializations` (
  `profileId` int(11) unsigned NOT NULL,
  `specializationId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`profileId`,`specializationId`),
  KEY `specializationId` (`specializationId`),
  CONSTRAINT `specialists__profiles_specializations_ibfk_1` FOREIGN KEY (`profileId`) REFERENCES `specialists__profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `specialists__profiles_specializations_ibfk_2` FOREIGN KEY (`specializationId`) REFERENCES `specialists__specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `specialists__groups` (`id`, `title`)
VALUES
	(1, 'Врачи');
	
	INSERT INTO `specialists__specializations` (title, groupId) VALUES 
('Детский аллерголог', '1'),
('Детский гастроэнтеролог', '1'),
('Детский гинеколог', '1'),
('Детский дерматолог', '1'),
('Детский кардиолог', '1'),
('Детский логопед', '1'),
('Детский ЛОР', '1'),
('Детский невропатолог', '1'),
('Детский окулист (Детский офтальмолог)', '1'),
('Детский ортопед', '1'),
('Детский педиатр', '1'),
('Детский психолог', '1'),
('Детский стоматолог', '1'),
('Детский травматолог', '1'),
('Детский уролог', '1'),
('Детский хирург', '1'),
('Детский эндокринолог', '1');
		");
	}

	public function down()
	{
		echo "m160824_080502_specialists3 does not support migration down.\n";
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