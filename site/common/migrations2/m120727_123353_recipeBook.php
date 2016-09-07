<?php

class m120727_123353_recipeBook extends CDbMigration
{
	public function up()
	{
        $this->execute("RENAME TABLE `happy_giraffe`.`recipe_book__ingredients` TO `happy_giraffe`.`recipe_book__ingredients_old` ;

CREATE TABLE `happy_giraffe`.`recipe_book__ingredients` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB;

INSERT INTO recipe_book__ingredients(title)
SELECT DISTINCT title
FROM recipe_book__ingredients_old;

CREATE TABLE IF NOT EXISTS `recipe_book__units` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title2` varchar(255) NOT NULL,
  `title3` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `recipe_book__units` (`id`, `title`, `title2`, `title3`) VALUES
(1, '1/2 ст', '1/2 ст', '1/2 ст'),
(4, 'г', 'г', 'г'),
(5, 'кг', 'кг', 'кг'),
(6, 'л', 'л', 'л'),
(7, 'мл', 'мл', 'мл'),
(8, 'ст', 'ст', 'ст'),
(9, 'ст. ложка', 'ст. ложка', 'ст. ложка'),
(10, 'ч', 'ч', 'ч'),
(11, 'ч. ложка', 'ч. ложка', 'ч. ложка'),
(12, 'штука', 'штуки', 'штук'),
(13, 'капля', 'капли', 'капель');

CREATE TABLE `happy_giraffe`.`recipe_book__recipes_ingredients` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`recipe_id` INT( 11 ) UNSIGNED NOT NULL ,
`unit_id` INT( 11 ) UNSIGNED NOT NULL ,
`ingredient_id` INT( 11 ) UNSIGNED NOT NULL ,
`value` DECIMAL( 6, 2 ) UNSIGNED NOT NULL ,
`display_value` VARCHAR( 6 ) NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `recipe_book__recipes_ingredients` ADD INDEX ( `recipe_id` ) ;
ALTER TABLE `recipe_book__recipes_ingredients` ADD INDEX ( `unit_id` ) ;
ALTER TABLE `recipe_book__recipes_ingredients` ADD INDEX ( `ingredient_id` ) ;

ALTER TABLE `recipe_book__recipes_ingredients` ADD FOREIGN KEY ( `recipe_id` ) REFERENCES `happy_giraffe`.`recipe_book__recipes` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `recipe_book__recipes_ingredients` ADD FOREIGN KEY ( `unit_id` ) REFERENCES `happy_giraffe`.`recipe_book__units` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `recipe_book__recipes_ingredients` ADD FOREIGN KEY ( `ingredient_id` ) REFERENCES `happy_giraffe`.`recipe_book__ingredients` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

INSERT INTO recipe_book__recipes_ingredients(recipe_id, unit_id, ingredient_id, value)
SELECT
recipe_id,
unit + 1,
(SELECT id FROM recipe_book__ingredients WHERE recipe_book__ingredients.title = recipe_book__ingredients_old.title),
amount
FROM recipe_book__ingredients_old;

DROP TABLE `recipe_book__recipes_votes` ;
DROP TABLE `recipe_book__purposes` ;
DROP TABLE `recipe_book__recipes_purposes` ;
DROP TABLE `recipe_book__ingredients_old` ;
ALTER TABLE `recipe_book__recipes` DROP `source_type` ,
DROP `internet_link` ,
DROP `internet_favicon` ,
DROP `internet_title` ,
DROP `book_author` ,
DROP `book_name` ,
DROP `views_amount` ,
DROP `votes_pro` ,
DROP `votes_con` ;");
	}

	public function down()
	{
		echo "m120727_123353_recipeBook does not support migration down.\n";
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