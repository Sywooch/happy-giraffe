<?php

class m140616_120448_seo extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `seo__yandex_original_texts`;

CREATE TABLE `seo__yandex_original_texts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) DEFAULT '',
  `entity_id` int(11) unsigned DEFAULT NULL,
  `added` timestamp NULL DEFAULT NULL,
  `full_text` text,
  `external_text` text,
  `external_id` char(32) DEFAULT '',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `priority` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `external_id` (`external_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m140616_120448_seo does not support migration down.\n";
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