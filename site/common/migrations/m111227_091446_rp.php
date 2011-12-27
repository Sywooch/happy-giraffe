<?php

class m111227_091446_rp extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `happy_giraffe`.`recipeBook_disease_category` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `happy_giraffe`.`recipeBook_disease` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `recipeBook_disease` ADD `category_id` INT( 11 ) UNSIGNED NOT NULL ;
ALTER TABLE `recipeBook_disease` ADD INDEX ( `category_id` ) ;

CREATE TABLE `happy_giraffe`.`recipeBook_recipe` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`disease_id` INT( 11 ) UNSIGNED NOT NULL ,
`text` TEXT NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `recipeBook_recipe` ADD INDEX ( `disease_id` ) ;

CREATE TABLE `happy_giraffe`.`recipeBook_ingredient` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`amount` DECIMAL( 5, 2 ) UNSIGNED NOT NULL ,
`unit` ENUM( 'g', 'ml' ) NOT NULL ,
`recipe_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `recipeBook_ingredient` ADD INDEX ( `recipe_id` ) ;

CREATE TABLE `happy_giraffe`.`recipeBook_purpose` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `happy_giraffe`.`recipeBook_recipe_via_purpose` (
`recipe_id` INT( 11 ) UNSIGNED NOT NULL ,
`purpose_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `recipeBook_recipe_via_purpose` ADD INDEX ( `recipe_id` ) ;
ALTER TABLE `recipeBook_recipe_via_purpose` ADD INDEX ( `purpose_id` ) ;

ALTER TABLE `recipeBook_disease` ADD `with_recipies` BOOLEAN NOT NULL ;
ALTER TABLE `recipeBook_disease` ADD `text` TEXT NOT NULL ;

ALTER TABLE `recipeBook_disease` ADD `reasons_name` VARCHAR( 255 ) NULL ,
ADD `symptoms_name` VARCHAR( 255 ) NULL ,
ADD `treatment_name` VARCHAR( 255 ) NULL ,
ADD `prophylaxis_name` VARCHAR( 255 ) NULL ,
ADD `reasons_text` TEXT NOT NULL ,
ADD `symptoms_text` TEXT NOT NULL ,
ADD `treatment_text` TEXT NOT NULL ,
ADD `prophylaxis_text` TEXT NOT NULL ;
		");
	}

	public function down()
	{
		echo "m111227_091446_rp does not support migration down.\n";
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