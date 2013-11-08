<?php

class m131108_102344_question extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `community__content_types` (`id`, `title`, `title_plural`, `title_accusative`, `slug`) VALUES ('7', 'Вопрос', 'Вопросы', 'Вопрос', 'question');");
        $this->execute("DROP TABLE IF EXISTS `community__questions`;

CREATE TABLE `community__questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) unsigned NOT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `community__questions_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `community__contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m131108_102344_question does not support migration down.\n";
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