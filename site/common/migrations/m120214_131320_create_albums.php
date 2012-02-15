<?php

class m120214_131320_create_albums extends CDbMigration
{
    public function up()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `albums` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `title` varchar(100) NOT NULL,
          `description` varchar(255) NOT NULL,
          `user_id` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_albums_user` (`user_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        CREATE TABLE IF NOT EXISTS `album_photos` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(10) unsigned NOT NULL,
          `album_id` int(10) unsigned NOT NULL,
          `file_name` varchar(100) NOT NULL,
          `fs_name` varchar(100) NOT NULL,
          `creation_date` datetime NOT NULL,
          PRIMARY KEY (`id`),
          KEY `fk_photo_user` (`user_id`),
          KEY `fk_photo_album` (`album_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
        ALTER TABLE `albums`
          ADD CONSTRAINT `fk_albums_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ALTER TABLE `album_photos`
            ADD CONSTRAINT `fk_photo_album` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_photo_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
    }

    public function down()
    {
        echo "m120214_131320_create_albums does not support migration down.\n";
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