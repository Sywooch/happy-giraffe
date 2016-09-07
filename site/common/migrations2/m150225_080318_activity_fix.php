<?php

class m150225_080318_activity_fix extends CDbMigration
{

    public function up()
    {
        $this->execute('ALTER TABLE `som__activity` CHANGE COLUMN `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;');
        $this->execute('ALTER TABLE `som__activity` ADD COLUMN `hash` VARCHAR(32) NOT NULL AFTER `data`, ADD UNIQUE INDEX `hash_UNIQUE` (`hash` ASC);');
        $this->execute('ALTER TABLE `som__activity` ADD INDEX `sort_dtimeCreate` (`dtimeCreate` DESC);');
        $this->execute(<<<SQL
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('post','Статья','Добавлена новая статья');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('videoPost','Видео','Добавлено новое видео');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('photoPost','Фотопост','Добавлен новый фотопост');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('status','Статус','Добавлен новый статус');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('question','Вопрос','Добавлен новый вопрос');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('comment','Комментарий','Добавлен новый комментарий');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('photo','Фотографии','Добавлены фотографии в альбом');
            INSERT INTO `som__activity_type` (`typeId`,`title`,`description`) VALUES ('advPost','Редакторский пост','Добавлен редакторский пост');
SQL
        );
    }

    public function down()
    {
        echo "m150225_080318_activity_fix does not support migration down.\n";
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
