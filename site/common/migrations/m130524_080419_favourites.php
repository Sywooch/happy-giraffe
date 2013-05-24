<?php

class m130524_080419_favourites extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `favourites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) NOT NULL,
  `entity_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
        $this->execute("CREATE TABLE IF NOT EXISTS `favourites__tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
        $this->execute("CREATE TABLE IF NOT EXISTS `favourites__tags_favourites` (
  `tag_id` int(11) unsigned NOT NULL,
  `favourite_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`,`favourite_id`),
  KEY `favourite_id` (`favourite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `favourites__tags_favourites`
  ADD CONSTRAINT `favourites__tags_favourites_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `favourites__tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourites__tags_favourites_ibfk_2` FOREIGN KEY (`favourite_id`) REFERENCES `favourites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
	}

	public function down()
	{
		echo "m130524_080419_favourites does not support migration down.\n";
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