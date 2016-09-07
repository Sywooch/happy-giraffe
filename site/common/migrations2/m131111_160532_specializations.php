<?php

class m131111_160532_specializations extends CDbMigration
{
	public function up()
	{
        $this->execute("
            # Dump of table specializations
            # ------------------------------------------------------------

            DROP TABLE IF EXISTS `specializations`;

            CREATE TABLE `specializations` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL DEFAULT '',
              `forum_id` int(11) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `forum_id` (`forum_id`),
              CONSTRAINT `specializations_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `community__forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            # Dump of table user__specializations
            # ------------------------------------------------------------

            DROP TABLE IF EXISTS `user__specializations`;

            CREATE TABLE `user__specializations` (
              `user_id` int(11) unsigned NOT NULL,
              `specialization_id` int(11) unsigned NOT NULL,
              PRIMARY KEY (`user_id`,`specialization_id`),
              KEY `specialization_id` (`specialization_id`),
              CONSTRAINT `user__specializations_ibfk_2` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `user__specializations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("INSERT INTO `specializations` (`id`, `title`, `forum_id`) VALUES (NULL, 'Гинеколог', '2');");
	}

	public function down()
	{
		echo "m131111_160532_specializations does not support migration down.\n";
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