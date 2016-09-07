<?php

class m120530_053541_insert_spices_categories extends CDbMigration
{
    public function up()
    {
        $this->execute("
        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

SET NAMES 'utf8';

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

INSERT INTO cook__spices__categories VALUES
  (1, 'к мясу', NULL),
  (2, 'к птице', NULL),
  (3, 'к рыбе', NULL),
  (4, 'к овощам и грибам', NULL),
  (5, 'к бобовым', NULL),
  (6, 'к крупам', NULL),
  (7, 'к макаронам', NULL),
  (8, 'к салатам', NULL),
  (9, 'к супам', NULL),
  (10, 'к соусам', NULL),
  (11, 'к хлебобулочным изделиям', NULL),
  (12, 'к кондитерским изделиям', NULL),
  (13, 'для маринадов', NULL),
  (14, 'для консервации и солений', NULL),
  (15, 'при изготовлении варения', NULL),
  (16, 'при приготовлении напитков', NULL);

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
        ");
    }

    public function down()
    {
        echo "m120530_053541_insert_spices_categories does not support migration down.\n";
        return false;
    }


}