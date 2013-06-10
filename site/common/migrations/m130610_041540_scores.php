<?php

class m130610_041540_scores extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD
        ALTER TABLE `score__user_scores` DROP `full`;
        UPDATE `score__user_scores` set `scores` = 0;
        ALTER TABLE  `score__user_scores` ADD  `seen_scores` INT UNSIGNED NOT NULL DEFAULT  '0' AFTER  `scores`;
        DROP TABLE `score__actions`;

        CREATE TABLE IF NOT EXISTS `score__achievements` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `description` text,
          `count` int(10) unsigned NOT NULL DEFAULT '0',
          `parent_id` int(10) unsigned DEFAULT NULL,
          `scores` smallint(5) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          KEY `parent_id` (`parent_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

        --
        -- Дамп данных таблицы `score__achievements`
        --

        INSERT INTO `score__achievements` (`id`, `title`, `description`, `count`, `parent_id`, `scores`) VALUES
        (1, 'Бронзовый блог', 'У вас уже 25 записей в блоге. \nПишите еще!', 25, NULL, 125),
        (2, 'Серебрянный блог', 'У вас уже 50 записей в блоге. \nПродолжайте творить!', 50, 1, 250),
        (3, 'Золотой блог', 'У вас уже 100 записей в блоге! \nЭто как черный пояс по писательству, поздравляем!', 100, 2, 500),
        (4, 'Комбо', 'Вы  разместили сразу  5 записей за сегодня! \nБудьте еще активней!', 5, NULL, 25),
        (5, 'Супер Комбо', 'Вы разместили сразу  10  постов за сегодня! \nПишите еще!', 10, 4, 50),
        (6, 'Мега Комбо', 'Вы разместили сразу 20  постов за сегодня! \nПишите еще!', 20, 5, 100),
        (7, 'Птица-говорун', 'У вас 50 комментариев! \nСкажите всем, что вы думаете по этому поводу!', 50, NULL, 25),
        (8, 'Общительный', 'У вас 200 комментариев! \nК вашему мнению прислушиваются многие!', 200, 7, 100),
        (9, 'Душа компании', 'У вас 500 комментариев! \nВы просто мастер слова!', 500, 8, 250),
        (10, 'Хороший Друг', 'У вас 25 друзей! \nНе стесняйтесь новых знакомств!', 25, NULL, 25),
        (11, 'Популярная личность', 'У вас 100 друзей! \nВаша общительность творит чудеса!', 100, 10, 100),
        (12, 'Звезда', 'У вас 500 друзей! \nВы  знаменитость!', 500, 11, 500),
        (13, '&laquo;Видеомания&raquo; Новичок', 'Вы добавили 10 видео. \nПродолжайте в том же духе!', 10, NULL, 25),
        (14, '&laquo;Видеомания&raquo; Любитель', 'Вы добавили 50 видео. \nПродолжайте в том же духе!', 50, 13, 125),
        (15, '&laquo;Видеомания&raquo; Эксперт', 'Вы добавили 100 видео. \nПродолжайте в том же духе!', 100, 14, 250),
        (16, 'Книгочей', 'Вы прочли 100 записей в клубах. \nТеперь вы знаете много интересного!', 100, NULL, 20),
        (17, 'Книголюб', 'Вы прочли 500 записей в клубах. \nВы настоящий интеллектуал!', 500, 16, 100),
        (18, 'Книжный червь', 'Вы прочли 5 000 записей в клубах. У вас высочайший уровень IQ в мире!', 5000, 17, 500),
        (22, 'Любитель поединков', NULL, 5, NULL, 50),
        (23, 'Заядлый дуэлянт', NULL, 10, 22, 100),
        (24, 'Отчаянный бретер', NULL, 20, 23, 200),
        (25, 'Клаббер', 'Вы оставили 10 записей в клубах. \nОтлично, не скрывайте своей точки зрения!', 10, NULL, 125),
        (26, 'СуперКлаббер', 'Вы оставили 50  записей в клубах. \nВы много знаете!', 50, 25, 250),
        (27, 'МегаКлаббер', 'Вы оставили 100 записей  в клубах. \nУ вас на все есть свое авторитетное мнение!', 100, 26, 500),
        (28, '&laquo;Фотомания&raquo; Начинающий', 'Вы выложили 25 фотографий. \nОтличное начало!', 25, NULL, 50),
        (29, '&laquo;Фотомания&raquo; Любитель', 'Вы выложили 100 фотографий.  \nПродолжайте в том же духе!', 100, 28, 200),
        (30, '&laquo;Фотомания&raquo;  Профи ', 'Вы выложили 250 фотографий.  \nПродолжайте в том же духе!', 250, 29, 500),
        (31, 'Оценщик', NULL, 50, NULL, 25),
        (32, 'Эстет', NULL, 100, 31, 50),
        (33, 'Ценитель прекрасного', NULL, 500, 32, 250),
        (34, 'Частый гость', 'Вы зашли на сайт 10 дней подряд! \nМы очень рады вам. :)', 10, NULL, 20),
        (35, 'Постоянный посетитель', 'Вы зашли на сайт 20 дней подряд. \nСпасибо, что вы с нами!', 20, 34, 50),
        (36, 'Завсегдатай', 'Вы зашли на сайт 40 дней подряд! \nВы знаете тут все!', 40, 35, 150);

        -- --------------------------------------------------------

        --
        -- Структура таблицы `score__actions`
        --

        CREATE TABLE IF NOT EXISTS `score__actions` (
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

        -- --------------------------------------------------------

        --
        -- Структура таблицы `score__awards`
        --

        CREATE TABLE IF NOT EXISTS `score__awards` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `description` text,
          `scores` smallint(6) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

        --
        -- Дамп данных таблицы `score__awards`
        --

        INSERT INTO `score__awards` (`id`, `title`, `description`, `scores`) VALUES
        (1, 'Лучший блогер недели', 'Поздравляем! Вы получили трофей &laquo;Лучший блоггер недели&raquo;. \nПродолжайте в том же духе!', 500),
        (2, 'Лучший блогер месяца', 'Поздравляем! Вы стали лучшим блогером месяца.\nПишите еще!', 1500),
        (3, 'Лучший комментатор недели', 'Поздравляем! Вы получили трофей &laquo;Лучший комментатор недели&raquo;. \nПродолжайте в том же духе!', 500),
        (4, 'Лучший комментатор месяца', 'Поздравляем! Вы стали лучшим комментатором месяца.\nПишите еще!', 1500),
        (5, 'Фотофан', 'Вам присвоен трофей &laquo;Фотофан&raquo; - за наибольшее количество фотографий, размещенных на сайте за месяц.\nФотографируйте еще!', 1000),
        (6, 'Орден Путешественника', 'за активное участие в клубе &laquo;Путешествия семьей&raquo;', 1000),
        (7, 'Орден Коко Шанель', 'за активное участие в клубе &laquo;Мода и шоппинг&raquo;', 1000),
        (8, 'Орден Мастерицы', 'за активное участие в клубах  &laquo;Мастерим детям&raquo;, &laquo;Своими руками&raquo;', 1000),
        (9, 'Орден Свадебного гуру', 'за активное участие в клубе &laquo;Свадьба&raquo;', 1000),
        (10, 'Орден Мастера на все руки', NULL, 1000),
        (11, 'Орден Домовладельца', NULL, 1000),
        (12, 'Орден Эксперта красоты', NULL, 1000),
        (13, 'Лучший кулинар', NULL, 1000),
        (14, 'Орден Массовик-затейник', NULL, 1000),
        (15, 'Орден Доктора Айболита', NULL, 1000),
        (16, 'Орден &laquo;Отчаянная домохозяйка&raquo;', NULL, 1000),
        (17, 'Семейный психолог', NULL, 1000),
        (18, 'Орден Почетного Материнства', NULL, 1000),
        (19, 'Автолюбитель', NULL, 1000),
        (20, 'Орден Пузяшки', NULL, 1000),
        (21, 'Экофан', NULL, 1000),
        (22, 'Самый общительный', 'Вы стали самым общительным пользователем сайта. \nОбщайтесь еще больше!', 1000),
        (23, 'Заядлый дуэлянт', NULL, 300),
        (24, 'Мисс/Мистер Улыбка', 'За смайлы в ваших постах вам присвоен трофей &laquo;Мисс/Мистер улыбка&raquo;!\nУлыбайтесь чаще!', 300);

        -- --------------------------------------------------------

        --
        -- Структура таблицы `score__users_awards`
        --

        CREATE TABLE IF NOT EXISTS `score__users_awards` (
          `user_id` int(10) unsigned NOT NULL,
          `award_id` int(10) unsigned NOT NULL,
          `created` date DEFAULT NULL,
          PRIMARY KEY (`user_id`,`award_id`),
          KEY `award_id` (`award_id`),
          KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        -- --------------------------------------------------------

        --
        -- Структура таблицы `score__user_achievements`
        --

        CREATE TABLE IF NOT EXISTS `score__user_achievements` (
          `user_id` int(10) unsigned NOT NULL,
          `achievement_id` int(10) unsigned NOT NULL,
          `created` date DEFAULT NULL,
          PRIMARY KEY (`user_id`,`achievement_id`),
          KEY `achievement_id` (`achievement_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        --
        -- Ограничения внешнего ключа сохраненных таблиц
        --

        --
        -- Ограничения внешнего ключа таблицы `score__users_awards`
        --
        ALTER TABLE `score__users_awards`
          ADD CONSTRAINT `score__users_awards_award` FOREIGN KEY (`award_id`) REFERENCES `score__awards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `score__users_awards_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

        --
        -- Ограничения внешнего ключа таблицы `score__user_achievements`
        --
        ALTER TABLE `score__user_achievements`
          ADD CONSTRAINT `score__user_achievements_achievement` FOREIGN KEY (`achievement_id`) REFERENCES `score__achievements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `score__user_achievements_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
EOD;
        $this->execute($sql);
	}

	public function down()
	{
		echo "m130610_041540_scores does not support migration down.\n";
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