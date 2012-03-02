<?php

class m120302_064923_create_removed extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comment` ADD `removed` BOOLEAN NOT NULL DEFAULT '0'");
        $this->execute("CREATE TABLE IF NOT EXISTS `removed` (
          `entity` varchar(50) NOT NULL,
          `entity_id` int(10) unsigned NOT NULL,
          `user_id` int(10) unsigned NOT NULL,
          `type` tinyint(4) NOT NULL,
          `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`entity`,`entity_id`),
          KEY `fk_removed_user` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("ALTER TABLE `removed`
          ADD CONSTRAINT `fk_removed_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `removed` ADD `text` VARCHAR( 100 ) NOT NULL AFTER `type` ");
	}

	public function down()
	{
		echo "m120302_064923_create_removed does not support migration down.\n";
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