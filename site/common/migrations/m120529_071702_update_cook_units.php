<?php

class m120529_071702_update_cook_units extends CDbMigration
{
    public function up()
    {
        $this->execute("

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

--
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';


--
-- Описание для таблицы cook__units
--
DROP TABLE IF EXISTS cook__units;
CREATE TABLE cook__units (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  title2 VARCHAR(255) DEFAULT NULL,
  title3 VARCHAR(255) DEFAULT NULL,
  type ENUM('weight','volume','qty','single','undefined') DEFAULT NULL,
  ratio DECIMAL(10, 4) UNSIGNED NOT NULL DEFAULT 1.0000,
  PRIMARY KEY (id),
  UNIQUE INDEX title (title)
)
ENGINE = INNODB
AUTO_INCREMENT = 27
AVG_ROW_LENGTH = 682
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Вывод данных для таблицы cook__units
--
INSERT INTO cook__units VALUES
  (1, 'г', 'г', 'г', 'weight', 1.0000),
  (2, 'кг', 'кг', 'кг', 'weight', 1000.0000),
  (3, 'шт', 'шт', 'шт', 'qty', 1.0000),
  (4, 'столовая ложка', 'столовые ложки', 'столовых ложек', 'volume', 15.0000),
  (5, 'чайная ложка', 'чайные ложки', 'чайных ложек', 'volume', 5.0000),
  (6, 'банка', 'банки', 'банок', 'qty', 1.0000),
  (7, 'головка', 'головки', 'головок', 'qty', 1.0000),
  (8, 'зубчик', 'зубчика', 'зубчиков', 'qty', 1.0000),
  (9, 'кусок', 'куска', 'кусков', 'qty', 1.0000),
  (10, 'миллилитр', 'миллилитра', 'миллилитров', '', 1.0000),
  (11, 'на кончике ножа', 'на кончике ножа', 'на кончике ножа', 'single', 1.0000),
  (12, 'по вкусу', 'по вкусу', 'по вкусу', 'undefined', 1.0000),
  (13, 'пучок', 'пучка', 'пучков', 'qty', 1.0000),
  (14, 'стакан', 'стакана', 'стаканов', 'volume', 250.0000),
  (15, 'стебель', 'стебля', 'стеблей', 'qty', 1.0000),
  (16, 'штука', 'штуки', 'штук', '', 1.0000),
  (17, 'щепотка', 'щепотки', 'щепоток', 'single', 3.0000),
  (18, 'л', 'л', 'л', 'volume', 1000.0000),
  (19, 'литр', 'литра', 'литров', '', 1.0000),
  (20, 'грамм', 'грамма', 'граммов', '', 1.0000),
  (21, 'килограмм', 'килограмма', 'килограммов', '', 1.0000),
  (24, 'мл', 'мл', 'мл', 'volume', 1.0000),
  (25, 'ч.л.', 'ч.л.', 'ч.л.', '', 1.0000),
  (26, 'гр.', 'гр.', 'гр.', '', 1.0000);

--
-- Включение внешних ключей
--
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;");
    }

    public function down()
    {
        echo "m120529_071702_update_cook_units does not support migration down.\n";
        return false;
    }

}