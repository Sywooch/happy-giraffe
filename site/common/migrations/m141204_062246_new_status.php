<?php

class m141204_062246_new_status extends CDbMigration
{

    public function up()
    {
        $this->execute(<<<SQL
CREATE TABLE IF NOT EXISTS `som__status_moods` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
SQL
        );
        $this->execute(<<<SQL
INSERT INTO `som__status_moods` (SELECT * FROM `user__moods`)
SQL
        );
        $this->execute(<<<SQL
CREATE TABLE IF NOT EXISTS `som__status` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(500) NOT NULL,
  `moodId` INT(10) UNSIGNED NULL DEFAULT NULL,
  `authorId` INT(10) UNSIGNED NOT NULL,
  `isRemoved` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `dtimeCreate` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_som__status_som__status_moods1_idx` (`moodId` ASC),
  CONSTRAINT `fk_som__status_som__status_moods1`
    FOREIGN KEY (`moodId`)
    REFERENCES `som__status_moods` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
SQL
        );
    }

    public function down()
    {
        echo "m141204_062246_new_status does not support migration down.\n";
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
