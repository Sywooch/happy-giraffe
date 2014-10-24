<?php

class m141015_142625_service_post extends CDbMigration
{
	public function up()
	{
        // Таблица post__contents
        $this->execute(<<<SQL
CREATE  TABLE IF NOT EXISTS `post__contents` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(255) NULL DEFAULT NULL ,
  `authorId` INT UNSIGNED NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `text` TEXT NULL DEFAULT NULL ,
  `html` TEXT NOT NULL ,
  `preview` TEXT NULL DEFAULT NULL ,
  `labels` TEXT NOT NULL DEFAULT '' ,
  `dtimeCreate` INT UNSIGNED NOT NULL ,
  `dtimeUpdate` INT UNSIGNED NULL DEFAULT NULL ,
  `dtimePublication` INT UNSIGNED NULL DEFAULT NULL ,
  `originService` VARCHAR(100) NOT NULL ,
  `originEntity` VARCHAR(100) NOT NULL ,
  `originEntityId` VARCHAR(100) NOT NULL ,
  `originManageInfo` TEXT NOT NULL ,
  `isDraft` TINYINT(1) NOT NULL DEFAULT 1 ,
  `uniqueIndex` INT NULL DEFAULT NULL ,
  `isNoindex` TINYINT(1) NOT NULL DEFAULT 1 ,
  `isNofollow` TINYINT(1) NOT NULL DEFAULT 1 ,
  `isAutoMeta` TINYINT(1) NOT NULL DEFAULT 1 ,
  `isAutoSocial` TINYINT(1) NOT NULL DEFAULT 1 ,
  `isRemoved` TINYINT(1) NOT NULL DEFAULT 0 ,
  `meta` TEXT NULL DEFAULT NULL ,
  `social` TEXT NULL DEFAULT NULL ,
  `template` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `authorId` (`authorId` ASC) ,
  INDEX `entity` (`originService` ASC, `originEntity` ASC, `originEntityId` ASC) ,
  INDEX `dtimePublication` (`dtimePublication` DESC) ,
  INDEX `dtimeCreate` (`dtimeCreate` DESC) )
ENGINE = InnoDB
SQL
            );
        // Таблица post__labels
        $this->execute(<<<SQL
CREATE  TABLE IF NOT EXISTS `post__labels` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `text` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `text` (`text` ASC) )
ENGINE = InnoDB
SQL
            );
        // Таблица post__tags
        $this->execute(<<<SQL
CREATE  TABLE IF NOT EXISTS `post__tags` (
  `contentId` INT UNSIGNED NOT NULL ,
  `labelId` BIGINT UNSIGNED NOT NULL ,
  PRIMARY KEY (`contentId`, `labelId`) ,
  INDEX `fk_post__labels` (`labelId` ASC) ,
  INDEX `fk_post__contents` (`contentId` ASC) ,
  CONSTRAINT `fk_post__contents`
    FOREIGN KEY (`contentId` )
    REFERENCES `happy_giraffe`.`post__contents` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post__labels`
    FOREIGN KEY (`labelId` )
    REFERENCES `happy_giraffe`.`post__labels` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
SQL
            );
	}

	public function down()
	{
		echo "m141015_142625_service_post does not support migration down.\n";
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