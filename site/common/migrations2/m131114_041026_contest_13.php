<?php

class m131114_041026_contest_13 extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `contest__contests` (`id`, `title`, `text`, `results_text`, `rules`, `from_time`, `till_time`, `status`, `last_updated`)
VALUES
	(12, 'Поделись улыбкою своей', '<p>Появление первых зубов - значимое событие не только для малыша, но и для всей семьи, ведь это означает, что ребенок стал еще немного взрослее.  А его лучезарная улыбка дарит тепло и радость окружающим, ведь нет ничего прекрасней счастливого малыша! </p>\n<p>Мы c нетерпением ждем фотографии вашего улыбающегося ребенка на конкурсе «Крепкие зубки. Поделись улыбкою своей». Покажите, что ваш ребенок самый счастливый, подарив чуточку тепла от его улыбки всем! </p>', '', '', '2013-11-01', '2013-11-25', 1, '2013-11-14 08:06:34');
");
	}

	public function down()
	{
		echo "m131114_041026_contest_13 does not support migration down.\n";
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