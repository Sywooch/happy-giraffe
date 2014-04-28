<?php

class m140410_075547_mail_dialogues extends CDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS `mail__tokens`;

            CREATE TABLE `mail__tokens` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `expires` int(11) unsigned NOT NULL,
              `user_id` int(10) unsigned NOT NULL,
              `hash` char(32) NOT NULL DEFAULT '',
              PRIMARY KEY (`id`),
              UNIQUE KEY `hash` (`hash`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `mail__tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            DROP TABLE IF EXISTS `mail__delivery`;

            CREATE TABLE `mail__delivery` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(10) unsigned NOT NULL,
              `type` varchar(255) NOT NULL DEFAULT '',
              `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `sent` timestamp NULL DEFAULT NULL,
              `clicked` timestamp NULL DEFAULT NULL,
              `hash` char(32) NOT NULL DEFAULT '',
              PRIMARY KEY (`id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `mail__delivery_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
		echo "m140410_075547_mail_dialogues does not support migration down.\n";
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