<?php

class m120608_150317_create_cook_choose extends CDbMigration
{
	public function up()
	{
        $sql = "
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

SET NAMES 'utf8';

DROP TABLE IF EXISTS cook__choose__categories;
CREATE TABLE cook__choose__categories (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 13
CHARACTER SET utf8
COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cook__choose;
CREATE TABLE cook__choose (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id INT(11) UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  title_accusative VARCHAR(255) NOT NULL,
  `desc` TEXT DEFAULT NULL,
  desc_quality TEXT DEFAULT NULL,
  desc_defective TEXT DEFAULT NULL,
  desc_check TEXT DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_cook__choose_cook__choose__categories_id FOREIGN KEY (category_id)
    REFERENCES cook__choose__categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO cook__choose__categories VALUES
  (1, 'Алкоголь'),
  (2, 'Бакалея'),
  (3, 'Напитки'),
  (4, 'Кулинария'),
  (5, 'Кондитерские изделия, десерты и сладости'),
  (6, 'Майонезы, кетчупы, соусы'),
  (7, 'Молочная продукция'),
  (8, 'Мясо, птица'),
  (9, 'Рыба и морепродукты'),
  (10, 'Специи, приправы, пряности'),
  (11, 'Овощи, фрукты, грибы'),
  (12, 'Хлебобулочные изделия');

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;";

        $this->execute($sql);
	}

	public function down()
	{
		echo "m120608_150317_create_cook_choose does not support migration down.\n";
		return false;
	}


}