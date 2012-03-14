<?php

class m120314_054049_change_score_actions extends CDbMigration
{
    private $_table = 'score__actions';
	public function up()
	{
        $this->truncateTable($this->_table);
        $this->execute("
        INSERT INTO `score__actions` (`id`, `title`, `scores_weight`, `wait_time`) VALUES
(1, 'Запись', 10, 0),
(2, 'йо-хо-хо', 2, 0),
(3, 'лайки  к каждой соц. сети', 1, 5),
(4, 'каждые 100 просмотров записи', 1, 5),
(5, 'каждые 10 комментариев к записи (кроме авторских)', 1, 5),
(6, 'Комментарии (к сервисам, записям, в гостевой). За каждый комментарий', 1, 5),
(7, 'Анкета - личная информация', 25, 0),
(8, 'Анкета - ваша фотография', 25, 0),
(9, 'Анкета - моя семья', 25, 0),
(10, 'Анкета - интересы', 25, 0),
(11, 'Возврат на сайт каждый день', 1, 0),
(12, '5 дней подряд', 5, 0),
(13, '20 дней подряд на сайте', 40, 0),
(14, 'Фотоальбом. За каждое фото', 1, 5),
(15, 'За каждого нового друга', 1, 5);");
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