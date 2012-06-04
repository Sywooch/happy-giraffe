<?php

class m120602_160907_rambler_stats extends CDbMigration
{
    private $_table = 'rambler_popularity';

	public function up()
	{
        $db_name = end(explode("=", Yii::app()->db->connectionString));
        $sql = <<<EOD

USE happy_giraffe_seo;


CREATE TABLE IF NOT EXISTS `rambler_popularity` (
  `keyword_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `rambler_popularity`
--
ALTER TABLE `rambler_popularity`
  ADD CONSTRAINT `fk_rambler_popularity_keywords` FOREIGN KEY (`keyword_id`) REFERENCES `keywords` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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