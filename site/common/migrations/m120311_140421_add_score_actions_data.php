<?php

class m120311_140421_add_score_actions_data extends CDbMigration
{
	public function up()
	{
        $this->truncateTable('score__actions');
        $this->execute("INSERT INTO `score__actions` (`id`, `title`, `scores_weight`) VALUES
(1, 'Запись', 10),
(2, 'йо-хо-хо', 2),
(3, 'лайки  к каждой соц. сети', 1),
(4, 'каждые 100 просмотров записи', 1),
(5, 'каждые 10 комментариев к записи (кроме авторских)', 1),
(6, 'Комментарии (к сервисам, записям, в гостевой). За каждый комментарий', 1),
(7, 'Анкета - личная информация', 25),
(8, 'Анкета - ваша фотография', 25),
(9, 'Анкета - моя семья', 25),
(10, 'Анкета - интересы', 25),
(11, 'Возврат на сайт каждый день', 1),
(12, '5 дней подряд', 5),
(13, '20 дней подряд на сайте', 40),
(14, 'Фотоальбом. За каждое фото', 1),
(15, 'За каждого нового друга', 1);");
	}

	public function down()
	{
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