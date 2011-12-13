<?php

class m111213_153954_edzpm_tables extends CDbMigration {

	public function up() {
		$sql = "
		CREATE TABLE `shop_delivery_edzpm_zone` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) DEFAULT NULL,
			`price` int(11) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->execute($sql);
		$sql = "
			CREATE TABLE `shop_delivery_edzpm_city_zone_link` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `city_id` int(11) NOT NULL,
			  `edzpm_zone_id` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `city_id` (`city_id`),
			  KEY `edzpm_zone_id` (`edzpm_zone_id`),
			  CONSTRAINT `shop_delivery_edzpm_city_zone_link_fk` FOREIGN KEY (`edzpm_zone_id`) REFERENCES `shop_delivery_edzpm_zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->execute($sql);
	}

	public function down() 
	{
		$this->dropTable('shop_delivery_edzpm_city_zone_link');
		$this->dropTable('shop_delivery_edzpm_zone');
	}
}