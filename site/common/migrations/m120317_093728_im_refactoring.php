<?php

class m120317_093728_im_refactoring extends CDbMigration
{
    public function up()
    {
        $this->execute("
SET foreign_key_checks = 0;

RENAME TABLE  `message_cache` TO  `user_cache` ;
RENAME TABLE  `message_deleted` TO  `im__deleted_messages` ;
RENAME TABLE  `message_dialog` TO  `im__dialogs` ;
RENAME TABLE  `message_dialog_deleted` TO  `im__dialog_deleted` ;
RENAME TABLE  `message_log` TO  `im__messages` ;
RENAME TABLE  `message_user` TO  `im__dialog_users` ;

TRUNCATE TABLE  `im__deleted_messages`;
TRUNCATE TABLE  `im__dialog_deleted`;

ALTER TABLE  `im__deleted_messages` ADD  `dialog_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE  `im__deleted_messages` ADD INDEX (  `dialog_id` );
ALTER TABLE  `im__deleted_messages` ADD FOREIGN KEY (  `dialog_id` ) REFERENCES  `im__dialogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE  `im__deleted_messages` ADD  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE  `im__messages` DROP  `updated`;

SET foreign_key_checks = 1;
        ");
    }

    public function down()
    {
        echo "m120317_093728_im_refactoring does not support migration down.\n";
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