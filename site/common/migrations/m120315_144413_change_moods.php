<?php

class m120315_144413_change_moods extends CDbMigration
{
	public function up()
	{
        $this->execute("delete from user_moods");
        $this->execute("ALTER TABLE user_moods AUTO_INCREMENT = 1");
        $this->execute("INSERT INTO `user_moods` (`id`, `name`) VALUES
        (1, 'Ем'),
        (2, 'Испуг'),
        (3, 'Грустный'),
        (4, 'Молчу'),
        (5, 'Подозрительно'),
        (6, 'Интересно'),
        (7, 'Все ОК'),
        (8, 'Голова кругом'),
        (9, 'Любовь'),
        (10, 'Подарок'),
        (11, 'Красотка'),
        (12, 'Радость'),
        (13, 'Задумался'),
        (14, 'Смущаюсь'),
        (15, 'Праздник'),
        (16, 'Стреляюсь'),
        (17, 'Драка'),
        (18, 'Отстой'),
        (19, 'Смешно'),
        (20, 'Улыбаюсь'),
        (21, 'Шопинг'),
        (22, 'Напеваю'),
        (23, 'Болею'),
        (24, 'Сплю'),
        (25, 'Плачу'),
        (26, 'Звезда'),
        (27, 'Падаю со смеху'),
        (28, 'Слушаю музыку'),
        (29, 'Тихо'),
        (30, 'В поиске'),
        (31, 'Отлично'),
        (32, 'Дразнюсь'),
        (33, 'Боюсь'),
        (34, 'В ярости'),
        (35, 'Есть повод');");
	}

	public function down()
	{
		echo "m120315_144413_change_moods does not support migration down.\n";
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