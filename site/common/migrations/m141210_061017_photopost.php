<?php

class m141210_061017_photopost extends CDbMigration
{

    public function up()
    {
        $this->execute(<<<SQL
CREATE TABLE IF NOT EXISTS `som__photopost` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `collectionId` INT(10) UNSIGNED NOT NULL,
  `authorId` INT(10) UNSIGNED NOT NULL,
  `isDraft` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `isRemoved` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `dtimeCreate` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
SQL
        );
    }

    public function down()
    {
        echo "m141210_061017_photopost does not support migration down.\n";
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
