<?php

class m170405_081422_geo_vk extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `vk__countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `iso` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `vk__regions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `countryId` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `countryId` (`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `vk__cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `regionId` int(11) unsigned DEFAULT NULL,
  `countryId` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `area` varchar(255) NOT NULL DEFAULT '',
  `region` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `regionId` (`regionId`),
  KEY `countryId` (`countryId`),
  KEY `title` (`title`),
  KEY `id` (`id`,`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m170405_081422_geo_vk does not support migration down.\n";
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