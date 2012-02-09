<?php

class m120209_120837_create_yohoho extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `ratings_yohoho` (
          `entity_id` int(11) NOT NULL,
          `entity_name` varchar(50) NOT NULL,
          `social_key` varchar(2) NOT NULL,
          `user_id` int(10) unsigned NOT NULL,
          KEY `fk_ratings_yohoho` (`entity_id`,`entity_name`,`social_key`),
          KEY `fk_ratings_yohoho_user` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("ALTER TABLE `ratings_yohoho`
          ADD CONSTRAINT `fk_ratings_yohoho_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `fk_ratings_yohoho` FOREIGN KEY (`entity_id`, `entity_name`, `social_key`) REFERENCES `ratings` (`entity_id`, `entity_name`, `social_key`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	public function down()
	{
		echo "m120209_120837_create_yohoho does not support migration down.\n";
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