<?php

class m120607_114555_update_cook_decorations extends CDbMigration
{
	public function up()
	{
        $this->execute("DELETE FROM cook__decorations");

        $this->execute("/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

SET NAMES 'utf8';
DROP TABLE IF EXISTS cook__decorations;
CREATE TABLE cook__decorations (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  photo_id INT(11) UNSIGNED NOT NULL,
  category_id INT(11) UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT FK_cook__decorations_cook__decorations__categories_id FOREIGN KEY (category_id)
    REFERENCES cook__decorations__categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;");
	}

	public function down()
	{
		echo "m120607_114555_update_cook_decorations does not support migration down.\n";
		return false;
	}

}