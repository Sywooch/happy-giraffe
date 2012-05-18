<?php

class m120518_120732_humor extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `humor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) unsigned NOT NULL,
  `votes_rofl` int(11) unsigned NOT NULL,
  `votes_lol` int(11) unsigned NOT NULL,
  `votes_sad` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `humor`
  ADD CONSTRAINT `humor_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `album__photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("CREATE TABLE IF NOT EXISTS `humor_votes` (
  `entity_id` int(11) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `vote` tinyint(3) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `humor_votes`
  ADD CONSTRAINT `humor_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `humor_votes_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `humor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
	}

	public function down()
	{
		echo "m120518_120732_humor does not support migration down.\n";
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