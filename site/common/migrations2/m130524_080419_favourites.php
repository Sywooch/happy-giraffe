<?php

class m130524_080419_favourites extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `favourites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) NOT NULL DEFAULT '',
  `model_id` int(11) unsigned NOT NULL,
  `entity` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) unsigned NOT NULL,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NULL DEFAULT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique` (`model_name`,`model_id`,`user_id`),
  KEY `User` (`user_id`),
  KEY `Entity` (`entity`),
  CONSTRAINT `User` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;");
        $this->execute("CREATE TABLE `favourites__tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;");
        $this->execute("CREATE TABLE `favourites__tags_favourites` (
  `tag_id` int(11) unsigned NOT NULL,
  `favourite_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`,`favourite_id`),
  KEY `Favourite` (`favourite_id`),
  CONSTRAINT `Favourite` FOREIGN KEY (`favourite_id`) REFERENCES `favourites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Tag` FOREIGN KEY (`tag_id`) REFERENCES `favourites__tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
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