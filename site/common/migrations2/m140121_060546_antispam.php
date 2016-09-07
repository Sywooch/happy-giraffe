<?php

class m140121_060546_antispam extends CDbMigration
{
	public function up()
	{
        $this->execute("
# Dump of table antispam__check
# ------------------------------------------------------------

DROP TABLE IF EXISTS `antispam__check`;

CREATE TABLE `antispam__check` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) NOT NULL DEFAULT '',
  `entity_id` int(11) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `moderator_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moderator_id` (`moderator_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `antispam__check_ibfk_1` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `antispam__check_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table antispam__report
# ------------------------------------------------------------

DROP TABLE IF EXISTS `antispam__report`;

CREATE TABLE `antispam__report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL,
  `reason` text,
  `moderator_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `moderator_id` (`moderator_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `antispam__report_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `antispam__report_ibfk_1` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table antispam__report_limit_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `antispam__report_limit_data`;

CREATE TABLE `antispam__report_limit_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` int(11) unsigned NOT NULL,
  `entity` varchar(255) NOT NULL DEFAULT '',
  `interval` int(11) unsigned NOT NULL,
  `maxCount` int(11) unsigned NOT NULL,
  `actualInterval` int(11) unsigned NOT NULL,
  `ids` text,
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `antispam__report_limit_data_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `antispam__report` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table antispam__status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `antispam__status`;

CREATE TABLE `antispam__status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `moderator_id` int(10) unsigned DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `moderator_id` (`moderator_id`),
  CONSTRAINT `antispam__status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `antispam__status_ibfk_2` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table soft_delete
# ------------------------------------------------------------

DROP TABLE IF EXISTS `soft_delete`;

CREATE TABLE `soft_delete` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) NOT NULL DEFAULT '',
  `entity_id` int(11) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `removed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `soft_delete_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
		echo "m140121_060546_antispam does not support migration down.\n";
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