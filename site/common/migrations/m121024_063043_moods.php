<?php

class m121024_063043_moods extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `happy_giraffe`.`user__moods` (`id`, `title`) VALUES (NULL, 'Повар'), (NULL, 'Мастер'), (NULL, 'Я крут'), (NULL, 'Хочу денег'), (NULL, 'Ангел'), (NULL, 'И тебя вылечу'), (NULL, 'Дразнюсь'), (NULL, 'Ловелас'), (NULL, 'Любовь'), (NULL, 'В поиске'), (NULL, 'Учусь'), (NULL, 'Фоткаю'), (NULL, 'На югах'), (NULL, 'Не слышу'), (NULL, 'Все по фен-шуй'), (NULL, 'Смущаюсь'), (NULL, 'Заложник'), (NULL, 'Не вижу'), (NULL, 'Умора'), (NULL, 'Рисую');");
	}

	public function down()
	{
		echo "m121024_063043_moods does not support migration down.\n";
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