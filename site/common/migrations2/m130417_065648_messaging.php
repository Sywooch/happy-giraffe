<?php

class m130417_065648_messaging extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `messaging__messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) unsigned NOT NULL,
  `thread_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `thread_id` (`thread_id`),
  KEY `created` (`created`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `messaging__messages`
  ADD CONSTRAINT `messaging__messages_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messaging__messages_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `messaging__threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("CREATE TABLE IF NOT EXISTS `messaging__messages_users` (
  `user_id` int(11) unsigned NOT NULL,
  `message_id` int(11) unsigned NOT NULL,
  `read` tinyint(1) unsigned DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`message_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `messaging__messages_users`
  ADD CONSTRAINT `messaging__messages_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messaging__messages_users_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messaging__messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("CREATE TABLE IF NOT EXISTS `messaging__threads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");
        $this->execute("CREATE TABLE IF NOT EXISTS `messaging__threads_users` (
  `user_id` int(11) unsigned NOT NULL,
  `thread_id` int(11) unsigned NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`thread_id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `messaging__threads_users`
  ADD CONSTRAINT `messaging__threads_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messaging__threads_users_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `messaging__threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
	}

	public function down()
	{
		echo "m130417_065648_messaging does not support migration down.\n";
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