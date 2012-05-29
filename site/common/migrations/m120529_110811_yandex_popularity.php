<?php

class m120529_110811_yandex_popularity extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD

USE happy_giraffe_seo;

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=42;

CREATE TABLE IF NOT EXISTS `parsing_session` (
  `id` int(10) unsigned NOT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `parsing_session` (`id`, `start`, `end`) VALUES
(1, '2012-05-29', NULL);


CREATE TABLE IF NOT EXISTS `yandex_rank` (
  `keyword_id` int(11) NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `value` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  KEY `keyword_id` (`keyword_id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `yandex_rank`
  ADD CONSTRAINT `fk_yandex_rank_session` FOREIGN KEY (`session_id`) REFERENCES `parsing_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yandex_rank_keyword` FOREIGN KEY (`keyword_id`) REFERENCES `keywords` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

EOD;

        $this->execute($sql);
	}

	public function down()
	{
		echo "m120529_110811_yandex_popularity does not support migration down.\n";
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