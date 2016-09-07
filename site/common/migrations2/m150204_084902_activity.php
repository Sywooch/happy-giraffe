<?php

class m150204_084902_activity extends CDbMigration
{
	public function up()
	{
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `som__activity_type` (
  `typeId` VARCHAR(20) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`typeId`))
ENGINE = InnoDB
SQL;
        $this->execute($sql);
        
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `som__activity` (
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `userId` INT(10) UNSIGNED NOT NULL,
  `typeId` VARCHAR(20) NOT NULL,
  `dtimeCreate` INT(10) UNSIGNED NOT NULL,
  `data` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_som__activity_users1_idx` (`userId` ASC),
  INDEX `fk_som__activity_som__type1_idx` (`typeId` ASC),
  CONSTRAINT `fk_som__activity_users1`
    FOREIGN KEY (`userId`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_som__activity_som__type1`
    FOREIGN KEY (`typeId`)
    REFERENCES `som__activity_type` (`typeId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
SQL;
        $this->execute($sql);
	}

	public function down()
	{
		echo "m150204_084902_activity does not support migration down.\n";
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