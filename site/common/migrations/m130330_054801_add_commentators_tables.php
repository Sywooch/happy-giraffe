<?php

class m130330_054801_add_commentators_tables extends CDbMigration
{
	public function up()
	{
        $sql = "CREATE TABLE IF NOT EXISTS `commentators__likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity` enum('CommunityContent','CookRecipe','BlogContent') NOT NULL,
  `entity_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `social_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

ALTER TABLE `commentators__likes`
  ADD CONSTRAINT `commentators__likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `commentators__links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(1024) NOT NULL,
  `entity` enum('CommunityContent','CookRecipe','BlogContent') NOT NULL,
  `entity_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entity` (`entity`,`entity_id`),
  KEY `url` (`url`(255)),
  KEY `created` (`created`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

ALTER TABLE `commentators__links`
  ADD CONSTRAINT `commentators__links_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

";
        $this->execute($sql);
	}

	public function down()
	{
		echo "m130330_054801_add_commentators_tables does not support migration down.\n";
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