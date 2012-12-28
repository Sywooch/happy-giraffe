<?php

class m121227_130759_se_traffic extends CDbMigration
{
	public function up()
	{
        $this->execute("
        CREATE TABLE IF NOT EXISTS `search_engines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `search_engines` (`id`, `url`) VALUES
(1, 'google'),
(2, 'blogs.yandex'),
(3, 'images.yandex'),
(4, 'yandex'),
(5, 'go.mail'),
(6, 'bing'),
(7, 'webalta.ru'),
(8, 'search.conduit'),
(9, 'nova.rambler'),
(10, 'nigma.ru'),
(11, 'search.qip.ru');

CREATE TABLE IF NOT EXISTS `search_engines_visits` (
  `page_id` int(10) unsigned NOT NULL,
  `month` varchar(10) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `search_engines_visits`
  ADD CONSTRAINT `search_engines_visits_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`);
        ");
	}

	public function down()
	{
		echo "m121227_130759_se_traffic does not support migration down.\n";
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