<?php

class m130610_091722_scores2 extends CDbMigration
{
	public function up()
	{
        $this->execute('drop table if exists `score__actions`');

        $sql = <<<EOD
        --
        -- Структура таблицы `score__actions`
        --

        CREATE TABLE `score__actions` (
          `id` int(10) unsigned NOT NULL,
          `title` varchar(256) DEFAULT NULL,
          `scores_weight` int(11) NOT NULL,
          `wait_time` int(11) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        --
        -- Дамп данных таблицы `score__actions`
        --

        INSERT INTO `score__actions` (`id`, `title`, `scores_weight`, `wait_time`) VALUES
        (1, 'Первая запись в личном блоге', 50, 0),
        (2, 'Новая запись', 20, 0),
        (3, 'Новое видео', 20, 0),
        (4, 'Новые друзья', 2, 5),
        (5, 'Новые комментарии', 1, 5),
        (6, 'Новые фото', 1, 5),
        (7, 'Посещение сайта', 2, 0),
        (8, 'Участие в дуэли', 10, 0),
        (9, 'Победа в дуэли', 10, 0),
        (10, 'Участие в конкурсе', 30, 0),
        (11, 'Победа в конкрусе', 1000, 0),
        (12, 'Второе место в конкурсе', 500, 0),
        (13, 'Третье место в конкурсе', 200, 0),
        (14, 'Четвертое место в конкурсе', 100, 0),
        (15, 'Пятое место в конкурсе', 100, 0);
EOD;
        $this->execute($sql);
	}

	public function down()
	{
		echo "m130610_091722_scores2 does not support migration down.\n";
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