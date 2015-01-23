<?php

class m150122_102859_newAuth extends CDbMigration
{

    public function up()
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `newauth__items` (
  `name` VARCHAR(64) NOT NULL,
  `type` INT(11) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `bizrule` TEXT NULL DEFAULT NULL,
  `data` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`name`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
SQL;
        $this->execute($sql);
        
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `newauth__assignments` (
  `itemname` VARCHAR(64) NOT NULL,
  `userid` VARCHAR(64) NOT NULL,
  `bizrule` TEXT NULL DEFAULT NULL,
  `data` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`itemname`, `userid`),
  CONSTRAINT `auth_assignment_itemname_fk0`
    FOREIGN KEY (`itemname`)
    REFERENCES `newauth__items` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;            
SQL;
        $this->execute($sql);
        
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `newauth__items_childs` (
  `parent` VARCHAR(64) NOT NULL,
  `child` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`parent`, `child`),
  INDEX `child` (`child` ASC),
  CONSTRAINT `auth_item_child_child_fk0`
    FOREIGN KEY (`child`)
    REFERENCES `newauth__items` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_parent_fk0`
    FOREIGN KEY (`parent`)
    REFERENCES `newauth__items` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
SQL;
        $this->execute($sql);
        
        $sql=<<<'SQL'
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('guest',2,'Гость',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('user',2,'Залогиненый пользователь',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('moderator',2,'Модератор',NULL,'');
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageOwnProfile',1,'Управление личной информацией о пользователе','return $params[\"userId\"] == \\Yii::app()->user->id;',NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageOwnContent',1,'Управление своим контентом (где автор)','return \\site\\frontend\\components\\AuthManager::checkOwner($params[\"entity\"], \\Yii::app()->user->id);',NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createPost',1,'Добавление общих типов контента',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('managePost',1,'Управление общими типами контента',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageComment',1,'Управление комментариями',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createComment',1,'Добавление комментария',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('updateComment',0,'Редактирование комментария',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removeComment',0,'Удаление комментария',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('managePhotopost',1,'Управление фотопостом',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createPhotopost',1,'Добавление фотопоста',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('updatePhotopost',0,'Редактирование фотопоста',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removePhotopost',0,'Удаление фотопоста',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageStatus',1,'Управление статусом',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createStatus',1,'Добавление статуса',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('updateStatus',0,'Редактирование статуса',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removeStatus',0,'Удаление статуса',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createPhotoAlbum',1,'Создание альбома',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('managePhotoAlbum',1,'Управление альбомами',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('editPhotoAlbum',0,'Редактирование комментария',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removePhotoAlbum',0,'Удаление альбома',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('restorePhotoAlbum',0,'Восстановление альбома',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('managePhotoAttach',1,'Управление альбомами','return $params[\"entity\"]->collection->getAuthor()->id == \\Yii::app()->user->id;',NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removePhotoAttach',0,'Удаление фотоаттача',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('restorePhotoAttach',0,'Восстановление фотоаттача',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageOwnPhotoCollection',1,'Управление своей фотоколлекцией','return $params[\"entity\"]->getAuthor()->id == \\Yii::app()->user->id;',NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('sortPhotoCollection',0,'Сортировка коллекции',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('addPhotos',0,'Перемещение аттачей',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('setCover',0,'Изменение обложки',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('moveAttaches',0,'Перемещение аттачей',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('uploadPhoto',1,'Загрузка фото',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('editPhoto',1,'Редактирование фото',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageOwnFamily',1,'Управление своей семьей','return $params[\"entity\"]->canManage(\\Yii::app()->user->id);',NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createFamily',0,'Создание семьи',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('updateFamily',0,'Редактирование семьи',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageOwnFamilyMembers',1,'Управление членами семьи','return $params[\"entity\"]->family->canManage(\\Yii::app()->user->id);',NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createFamilyMember',0,'Создание члена семьи',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('updateFamilyMember',0,'Редактирование члена семьи',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removeFamilyMember',0,'Удаление члена семьи',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('restoreFamilyMember',0,'Восстановление члена семьи',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('setAvatar',0,'Изменение аватары',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removeAvatar',0,'Удаление аватары',NULL,NULL);
SQL;
        $this->execute($sql);
        
        $sql=<<<'SQL'
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','guest');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','manageOwnProfile');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','manageOwnContent');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','createComment');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','createPost');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','manageOwnPhotoCollection');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','createPhotoAlbum');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','managePhotoAttach');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','uploadPhoto');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','manageOwnFamily');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','manageOwnFamilyMembers');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','createFamily');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('user','createFamilyMember');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('moderator','user');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnProfile','setAvatar');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnProfile','removeAvatar');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnContent','manageComment');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnContent','managePost');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnContent','managePhotoAlbum');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnContent','editPhoto');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('createPost','createPhotopost');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('createPost','createStatus');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePost','managePhotopost');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePost','manageStatus');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageComment','updateComment');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageComment','removeComment');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotopost','updatePhotopost');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotopost','removePhotopost');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageStatus','updateStatus');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageStatus','removeStatus');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotoAlbum','editPhotoAlbum');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotoAlbum','removePhotoAlbum');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotoAlbum','restorePhotoAlbum');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotoAttach','removePhotoAttach');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePhotoAttach','restorePhotoAttach');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnPhotoCollection','addPhotos');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnPhotoCollection','sortPhotoCollection');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnPhotoCollection','setCover');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnPhotoCollection','moveAttaches');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnFamily','updateFamily');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnFamilyMembers','updateFamilyMember');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnFamilyMembers','removeFamilyMember');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageOwnFamilyMembers','restoreFamilyMember');
SQL;
        $this->execute($sql);
    }

    public function down()
    {
        echo "m150122_102859_newAuth does not support migration down.\n";
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
