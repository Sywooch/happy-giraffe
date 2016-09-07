<?php

class m130206_120811_valentine__videos extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `valentine__videos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vimeo_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `photo_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;


ALTER TABLE `valentine__videos`
  ADD CONSTRAINT `valentine__videos_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `album__photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
	}

	public function down()
	{
		echo "m130206_120811_valentine__videos does not support migration down.\n";
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