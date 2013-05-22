<?php

class m130427_095457_friends extends CDbMigration
{
	public function up()
	{
        $this->execute("RENAME TABLE  `friends` TO  `friends_old` ;");
        $this->execute("CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `friend_id` int(11) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `list_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `list_id` (`list_id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_3` FOREIGN KEY (`list_id`) REFERENCES `friends__lists` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("CREATE TABLE IF NOT EXISTS `friends__lists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `friends__lists`
  ADD CONSTRAINT `friends__lists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("
            INSERT INTO friends (user_id, friend_id, created)
              (
                SELECT
                  user1_id,
                  user2_id,
                  created
                FROM friends_old
              )
              UNION
              (
                SELECT
                  user2_id,
                  user1_id,
                  created
                FROM friends_old
              )
        ");
	}

	public function down()
	{
		echo "m130427_095457_friends does not support migration down.\n";
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