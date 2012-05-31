<?php

class m120531_100649_create_ingredient_units extends CDbMigration
{
	public function up()
	{
        $this->execute("
CREATE TABLE cook__ingredient_units(
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  ingredient_id INT(11) UNSIGNED NOT NULL,
  unit_id INT(11) UNSIGNED NOT NULL,
  weight INT(11) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX UK_cook__ingredient_units (ingredient_id, unit_id),
  CONSTRAINT FK_cook__ingredient_units_cook__ingredients_id FOREIGN KEY (ingredient_id)
  REFERENCES cook__ingredients (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_cook__ingredient_units_cook__units_id FOREIGN KEY (unit_id)
  REFERENCES cook__units (id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 11
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;
        ");
	}

	public function down()
	{
		echo "m120531_100649_create_ingredient_units does not support migration down.\n";
		return false;
	}

}