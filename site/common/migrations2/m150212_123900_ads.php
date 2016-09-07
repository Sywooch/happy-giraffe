<?php

class m150212_123900_ads extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(100) NOT NULL DEFAULT '',
  `entityId` varchar(100) NOT NULL DEFAULT '',
  `preset` varchar(100) DEFAULT NULL,
  `properties` text,
  `lineId` varchar(100) NOT NULL DEFAULT '',
  `creativeId` varchar(100) NOT NULL DEFAULT '',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `dtimeCreate` int(11) unsigned NOT NULL,
  `dtimeUpdate` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
	}

	public function down()
	{
		echo "m150212_123900_ads does not support migration down.\n";
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