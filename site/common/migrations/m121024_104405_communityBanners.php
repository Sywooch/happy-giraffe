<?php

class m121024_104405_communityBanners extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `happy_giraffe`.`auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('communityBanners', '0', 'Управление баннерами в сообществах', NULL, NULL);");
        $this->execute("CREATE TABLE IF NOT EXISTS `community__banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) unsigned NOT NULL,
  `photo_id` int(11) unsigned DEFAULT NULL,
  `class` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `community__banners`
  ADD CONSTRAINT `community__banners_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `community__contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `community__banners_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `album__photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
	}

	public function down()
	{
		echo "m121024_104405_communityBanners does not support migration down.\n";
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