<?php

class m120529_124604_prepare_keywords extends CDbMigration
{
	public function up()
	{
        $db_name = end(explode("=", Yii::app()->db->connectionString));
        $sql = <<<EOD

USE happy_giraffe_seo;

CREATE TABLE IF NOT EXISTS `parsing_keywords` (
  `keyword_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `parsing_keywords`
  ADD CONSTRAINT `fk_parsing_keywords_keyword` FOREIGN KEY (`keyword_id`) REFERENCES `keywords` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

USE $db_name;
EOD;

        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk))
            $this->execute($sql);
	}

	public function down()
	{
		echo "m120529_124604_prepare_keywords does not support migration down.\n";
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