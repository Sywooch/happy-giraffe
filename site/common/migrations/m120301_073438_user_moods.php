<?php

class m120301_073438_user_moods extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `user_moods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

INSERT INTO `user_moods` (`id`, `name`) VALUES
(1, 'Отличное'),
(2, 'Печальное'),
(3, 'Ранен'),
(4, 'В ярости'),
(5, 'Зол'),
(6, 'Влюблен'),
(7, 'Радость'),
(8, 'Повезло'),
(9, 'Тайна'),
(10, 'Страх'),
(11, 'Голова кругом'),
(12, 'Думаю'),
(13, 'Все ОК'),
(14, 'Бессилие'),
(15, 'Привет ВСЕМ'),
(16, 'Не мое');

ALTER TABLE `user` ADD `mood_id` INT( 11 ) UNSIGNED NULL ;
ALTER TABLE `user` ADD INDEX ( `mood_id` ) ;

ALTER TABLE `user` ADD FOREIGN KEY ( `mood_id` ) REFERENCES `happy_giraffe`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m120301_073438_user_moods does not support migration down.\n";
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