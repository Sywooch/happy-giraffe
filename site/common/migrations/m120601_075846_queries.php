<?php

class m120601_075846_queries extends CDbMigration
{
	public function up()
	{
        $db_name = end(explode("=", Yii::app()->db->connectionString));
        $sql = <<<EOD
USE happy_giraffe_seo;

-- --------------------------------------------------------

--
-- Структура таблицы `proxies`
--

CREATE TABLE IF NOT EXISTS `proxies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96719 ;

-- --------------------------------------------------------

--
-- Структура таблицы `queries`
--

CREATE TABLE IF NOT EXISTS `queries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phrase` varchar(1024) NOT NULL,
  `visits` int(10) unsigned NOT NULL,
  `page_views` int(10) unsigned NOT NULL,
  `denial` float unsigned NOT NULL,
  `depth` float unsigned NOT NULL,
  `visit_time` mediumint(8) unsigned NOT NULL,
  `parsing` int(1) NOT NULL DEFAULT '0',
  `yandex_parsed` tinyint(1) NOT NULL DEFAULT '0',
  `google_parsed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4570 ;

-- --------------------------------------------------------

--
-- Структура таблицы `query_pages`
--

CREATE TABLE IF NOT EXISTS `query_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `query_id` int(10) unsigned NOT NULL,
  `page_url` varchar(1024) DEFAULT NULL,
  `article_id` int(11) unsigned DEFAULT NULL,
  `yandex_position` smallint(5) unsigned DEFAULT NULL,
  `google_position` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_query_pages_query` (`query_id`),
  KEY `fk_query_pages_article` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=146 ;

-- --------------------------------------------------------

--
-- Структура таблицы `query_search_engines`
--

CREATE TABLE IF NOT EXISTS `query_search_engines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `query_id` int(10) unsigned NOT NULL,
  `se_id` int(10) unsigned DEFAULT NULL,
  `se_page` int(10) unsigned DEFAULT NULL,
  `se_url` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `query_id_2` (`query_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=521 AUTO_INCREMENT=9201 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `query_pages`
--
ALTER TABLE `query_pages`
  ADD CONSTRAINT `fk_query_pages_article` FOREIGN KEY (`article_id`) REFERENCES `article_keywords` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_query_pages_query` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `query_search_engines`
--
ALTER TABLE `query_search_engines`
  ADD CONSTRAINT `fk_query_search_engines_query` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



USE $db_name;

EOD;

        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk))
            $this->execute($sql);
	}

	public function down()
	{
		echo "m120601_075846_queries does not support migration down.\n";
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