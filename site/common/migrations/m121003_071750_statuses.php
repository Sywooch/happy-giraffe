<?php

class m121003_071750_statuses extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `community__statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;


ALTER TABLE `community__statuses`
  ADD CONSTRAINT `community__statuses_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `user__statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `community__statuses_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `community__contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("INSERT INTO `community__content_types` (`id`, `title`, `title_plural`, `title_accusative`, `slug`) VALUES
(5, 'Статус', 'Статусы', 'Статус', 'status');
");
	}

	public function down()
	{
		echo "m121003_071750_statuses does not support migration down.\n";
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