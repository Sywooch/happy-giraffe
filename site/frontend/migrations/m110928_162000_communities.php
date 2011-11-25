<?php

class m110928_162000_communities extends CDbMigration
{
    public function up()
    {
	$sql = "ALTER TABLE `club_community_article` ADD `internet_favicon` VARCHAR( 255 ) NULL AFTER `internet_link` ,
ADD `internet_title` VARCHAR( 255 ) NULL AFTER `internet_favicon` ;";
	$this->execute($sql);
	$sql = "DROP TABLE `club_community_content_type`;";
	$this->execute($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `club_community_content_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_plural` varchar(255) NOT NULL,
  `name_accusative` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
	$this->execute($sql);	
	$sql = "INSERT INTO `club_community_content_type` (`id`, `name`, `name_plural`, `name_accusative`, `slug`) VALUES
(1, 'Статья', 'Статьи', 'Статью', 'article'),
(2, 'Видео', 'Видео', 'Видео', 'video');";
	$this->execute($sql);
    	$sql = "ALTER TABLE `club_community_video` ADD `player_favicon` VARCHAR( 255 ) NOT NULL ,
ADD `player_title` VARCHAR( 255 ) NOT NULL ;";
	$this->execute($sql);
    }
 
    public function down()
    {
        echo "m110928_162000_communities does not support migration down.\n";
        return false;
    }
}