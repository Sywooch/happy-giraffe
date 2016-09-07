<?php

class m120613_165859_update_cook_choose extends CDbMigration
{
	public function up()
	{
        $this->execute("
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS cook__choose__categories;
CREATE TABLE cook__choose__categories (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  title_accusative VARCHAR(255) NOT NULL,
  description TEXT DEFAULT NULL,
  description_extra TEXT DEFAULT NULL,
  photo_id INT(11) UNSIGNED NOT NULL,
  slug VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cook__choose;
CREATE TABLE cook__choose (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id INT(11) UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  title_accusative VARCHAR(255) NOT NULL,
  `desc` TEXT DEFAULT NULL,
  title_quality VARCHAR(255) NOT NULL,
  desc_quality TEXT DEFAULT NULL,
  title_defective VARCHAR(255) NOT NULL,
  desc_defective TEXT DEFAULT NULL,
  title_check VARCHAR(255) NOT NULL,
  desc_check TEXT DEFAULT NULL,
  photo_id INT(11) UNSIGNED NOT NULL,
  slug VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_cook__choose_cook__choose__categories_id FOREIGN KEY (category_id)
    REFERENCES cook__choose__categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO cook__choose__categories VALUES
  (1, 'Алкоголь', 'алкоголь', NULL, NULL, NULL, 'Alkogol'),
  (2, 'Напитки', 'напитки', NULL, NULL, NULL, 'Napitki'),
  (3, 'Кондитерские изделия, десерты и сладости', 'кондитерские изделия, десерты и сладости', NULL, NULL, NULL, 'Konditerskie_izdeliya_deserti_i_sladosti'),
  (4, 'Майонезы, кетчупы, соусы', 'майонезы, кетчупы, соусы', NULL, NULL, NULL, 'Maionezi_ketchupi_sousi'),
  (5, 'Молочная продукция', 'молочную продукцию', NULL, NULL, NULL, 'Molochnaya_produkciya'),
  (6, 'Мясо, птица', 'мясо, птицу', NULL, NULL, NULL, 'Myaso_ptica'),
  (7, 'Рыба и морепродукты', 'рыбу и морепродукты', NULL, NULL, NULL, 'Riba_i_moreprodukti'),
  (8, 'Масла', 'масла', NULL, NULL, NULL, 'Masla'),
  (9, 'Овощи, фрукты, грибы', 'овощи, фрукты, грибы', NULL, NULL, NULL, 'Ovoshi_frukti_gribi'),
  (10, 'Хлебобулочные изделия и крупы', 'хлебобулочные изделия и крупы', NULL, NULL, NULL, 'Xlebobulochnie_izdeliya_i_krupi');


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;");
	}

	public function down()
	{
		echo "m120613_165859_update_cook_choose does not support migration down.\n";
		return false;
	}


}