<?php

class m161011_114519_advanced_authorization extends CDbMigration
{

	public function safeUp()
	{
         $this->execute("
            ALTER TABLE `specialists__profiles` ADD `authorization_status` TINYINT(3) NOT NULL DEFAULT 1, ADD INDEX (authorization_status);

            CREATE TABLE `specialists__authorization_tasks` (
    	        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    	        `task_type` int(11) unsigned NOT NULL,
    	        PRIMARY KEY (`id`),
    	        KEY `task_type` (`task_type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `specialists__group_type_relation` (
    	        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    	        `group_id` int(11) unsigned NOT NULL,
    	        `task_id` int(11) unsigned NOT NULL,
    	        PRIMARY KEY (`id`),
    	        KEY `group_id` (`group_id`),
    	        CONSTRAINT `specialists__group_type_relation_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `specialists__groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    	        CONSTRAINT `specialists__group_type_relation_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `specialists__authorization_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `specialists__profile_authorization_tasks` (
    	        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    	        `user_id` int(11) unsigned NOT NULL,
    	        `group_relation_id` int(11) unsigned NOT NULL,
    	        `status` tinyint(3) unsigned NOT NULL,
    	        `updated` timestamp NOT NULL,
    	        `created` timestamp NOT NULL,
    	        PRIMARY KEY (`id`),
    	        UNIQUE INDEX `user_id__group_relation_id` (`user_id`, `group_relation_id`),
    	        KEY `status` (`status`),
    	        CONSTRAINT `specialists__authorization_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    	        CONSTRAINT `specialists__authorization_tasks_ibfk_2` FOREIGN KEY (`group_relation_id`) REFERENCES `specialists__group_type_relation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

             INSERT INTO `specialists__authorization_tasks` (`id`, `task_type`) VALUES (1, 1);
             INSERT INTO `specialists__authorization_tasks` (`id`, `task_type`) VALUES (2, 2);
             INSERT INTO `specialists__group_type_relation` (`id`, `group_id`, `task_id`) VALUES (1, 1, 1);
             INSERT INTO `specialists__group_type_relation` (`id`, `group_id`, `task_id`) VALUES (2, 1, 2);
         ");
	}

	public function safeDown()
	{
	    $this->dropColumn('specialists__profiles', 'authorization_status');
	    $this->execute("SET FOREIGN_KEY_CHECKS=0;");
	    $this->dropTable('specialists__authorization_tasks');
	    $this->dropTable('specialists__group_type_relation');
	    $this->dropTable('specialists__profile_authorization_tasks');
	    $this->execute("SET FOREIGN_KEY_CHECKS=1;");
	}

}