<?php

class m120518_042801_duels extends CDbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE IF NOT EXISTS `duel__question` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `text` text NOT NULL,
              `ends` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            CREATE TABLE IF NOT EXISTS `duel__answer` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `text` text NOT NULL,
              `question_id` int(11) unsigned NOT NULL,
              `user_id` int(10) unsigned NOT NULL,
              `votes` int(11) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `question_id` (`question_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


            ALTER TABLE `duel__answer`
              ADD CONSTRAINT `duel__answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `duel__question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `duel__answer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            CREATE TABLE IF NOT EXISTS `duel__answer_votes` (
              `entity_id` int(11) unsigned NOT NULL,
              `user_id` int(10) unsigned NOT NULL,
              `vote` tinyint(1) NOT NULL,
              KEY `entity_id` (`entity_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


            ALTER TABLE `duel__answer_votes`
              ADD CONSTRAINT `duel__answer_votes_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `duel__answer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `duel__answer_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
            INSERT INTO `duel__question` (
            `id` ,
            `text` ,
            `ends`
            )
            VALUES (
            NULL , 'Шикарная свадьба - деньги на ветер или память на всю жизнь?', NULL
            ), (
            NULL , 'Есть ли другая жизнь во вселенной?', NOW( )
            ), (
            NULL , 'Крестить ребенка в младенчестве или ждать сознательного возраста?', NOW( )
            );
        ");
	}

	public function down()
	{
		echo "m120518_042801_duels does not support migration down.\n";
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