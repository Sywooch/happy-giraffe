<?php

class m170405_084033_geo_combined extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `geo2__country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `iso` char(2) NOT NULL DEFAULT '',
  `vkId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `geo2__region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `countryId` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `vkId` int(11) DEFAULT NULL,
  `fiasId` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryId` (`countryId`),
  CONSTRAINT `geo2__region_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `geo2__country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `geo2__city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `countryId` int(11) unsigned NOT NULL,
  `regionId` int(11) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `vkId` int(11) unsigned DEFAULT NULL,
  `fiasId` varchar(36) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryId` (`countryId`),
  KEY `regionId` (`regionId`),
  KEY `vkId` (`vkId`),
  KEY `fiasId` (`fiasId`),
  KEY `title` (`title`),
  CONSTRAINT `geo2__city_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `geo2__country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `geo2__city_ibfk_2` FOREIGN KEY (`regionId`) REFERENCES `geo2__region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->execute("CREATE TABLE `geo2__user_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `countryId` int(11) unsigned DEFAULT NULL,
  `regionId` int(11) unsigned DEFAULT NULL,
  `cityId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryId` (`countryId`),
  KEY `regionId` (`regionId`),
  KEY `cityId` (`cityId`),
  CONSTRAINT `geo2__user_location_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `geo2__country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `geo2__user_location_ibfk_2` FOREIGN KEY (`regionId`) REFERENCES `geo2__region` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `geo2__user_location_ibfk_3` FOREIGN KEY (`cityId`) REFERENCES `geo2__city` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m170405_084033_geo_combined does not support migration down.\n";
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