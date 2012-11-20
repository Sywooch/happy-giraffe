<?php

class m121108_043459_contest_results extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `contest__contests` ADD  `results_text` TEXT NOT NULL AFTER  `text`");
        $this->execute("UPDATE `happy_giraffe`.`contest__contests` SET `results_text` = '	<p>Уважаемые пользователи, рады сообщить вам итоги конкурса «Веселая семейка»<br/>
        Благодарим всех пользователей, принявших участие и поделившихся замечательными интересными и яркими моментами вашей семейной жизни!
	</p>

	<p>Внимание!<br/>
        Так как в ходе проверки голосования были выявлены случаи искусственной накрутки голосов, было принято решение о создании экспертной комиссии для независимой оценки фотографий и определения победителей. <br/>
        Поздравляем победителей!
	</p>' WHERE `contest__contests`.`id` = 1;");
        $this->execute("CREATE TABLE IF NOT EXISTS `contest__winners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `place` tinyint(1) unsigned NOT NULL,
  `work_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `contest__winners`
  ADD CONSTRAINT `contest__winners_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `contest__works` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
");
        $this->execute("INSERT INTO `happy_giraffe`.`contest__winners` (`id`, `place`, `work_id`) VALUES (NULL, '1', '117'), (NULL, '2', '128'), (NULL, '3', '248'), (NULL, '4', '43'), (NULL, '5', '220');");

	}

	public function down()
	{
		echo "m121108_043459_contest_results does not support migration down.\n";
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