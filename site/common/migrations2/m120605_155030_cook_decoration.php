<?php

class m120605_155030_cook_decoration extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
SET NAMES 'utf8';
DROP TABLE IF EXISTS cook__decorations__categories;
CREATE TABLE cook__decorations__categories (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  title_h1 VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 8
AVG_ROW_LENGTH = 2340
CHARACTER SET utf8
COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cook__decorations;
CREATE TABLE cook__decorations (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  photo_id INT(11) UNSIGNED NOT NULL,
  category_id INT(11) UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_cook__decorations_cook__decorations__categories_id FOREIGN KEY (category_id)
    REFERENCES cook__decorations__categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 11
AVG_ROW_LENGTH = 2048
CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO cook__decorations__categories VALUES
  (1, 'Салаты', 'салаты'),
  (2, 'Первые блюда', 'первые блюда'),
  (3, 'Вторые блюда', 'вторые блюда'),
  (4, 'Десерты и выпечка', 'десерты и выпечку'),
  (5, 'Детские блюда', 'детские блюда'),
  (6, 'Из овощей, фруктов и ягод', 'блюда из овощей фруктов и ягод'),
  (7, 'Напитки', 'напитки');

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
EOD;

        $this->execute($sql);
	}

	public function down()
	{
		echo "m120605_155030_cook_decoration does not support migration down.\n";
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