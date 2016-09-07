<?php

class m120528_174236_create_spices extends CDbMigration
{
    public function up()
    {
        $this->execute("
-- Отключение внешних ключей
--
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

--
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

--
-- Описание для таблицы cook__spices
--
DROP TABLE IF EXISTS cook__spices;
CREATE TABLE cook__spices (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  ingredient_id INT(11) UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT DEFAULT NULL,
  photo VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX title (title),
  CONSTRAINT FK_cook__spices_cook__ingredients_id FOREIGN KEY (ingredient_id)
    REFERENCES cook__ingredients(id) ON DELETE RESTRICT ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы cook__spices__categories
--
DROP TABLE IF EXISTS cook__spices__categories;
CREATE TABLE cook__spices__categories (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content TEXT DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX title (title)
)
ENGINE = INNODB
AUTO_INCREMENT = 17
AVG_ROW_LENGTH = 1024
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы cook__spices__categories_spices
--
DROP TABLE IF EXISTS cook__spices__categories_spices;
CREATE TABLE cook__spices__categories_spices (
  spice_id INT(11) UNSIGNED NOT NULL,
  category_id INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (category_id, spice_id),
  CONSTRAINT FK_cook__spices__categories_spices_cook__spices__categories_id FOREIGN KEY (category_id)
    REFERENCES cook__spices__categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_cook__spices__categories_spices_cook__spices_id FOREIGN KEY (spice_id)
    REFERENCES cook__spices(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы cook__spices__hints
--
DROP TABLE IF EXISTS cook__spices__hints;
CREATE TABLE cook__spices__hints (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  spice_id INT(11) UNSIGNED NOT NULL,
  content TEXT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_cook__spices__hints_cook__spices_id FOREIGN KEY (spice_id)
    REFERENCES cook__spices(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Включение внешних ключей
--
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;");
    }

    public function down()
    {
        echo "m120528_174236_create_spices does not support migration down.\n";
        return false;
    }

}