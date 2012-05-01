<?php

class m120430_092750_shop__product_eav_text_values extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `happy_giraffe`.`shop__product_eav_text_values` (
        `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `value` TEXT NOT NULL
        ) ENGINE = InnoDB;");
        $this->execute("ALTER TABLE `shop__product_eav_text` ADD `value_id` INT( 10 ) UNSIGNED NOT NULL ");
        $this->execute("TRUNCATE `shop__product_eav_text`");
        $this->execute("ALTER TABLE `shop__product_eav_text` ADD CONSTRAINT `fk_product_eav_value` FOREIGN KEY ( `value_id` ) REFERENCES `shop__product_eav_text_values` ( `id` ) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("ALTER TABLE `shop__product_eav_text` DROP `eav_attribute_value`");
        $this->execute("CREATE TABLE `happy_giraffe`.`shop__product_items` (
        `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `product_id` INT( 10 ) UNSIGNED NOT NULL ,
        `attributes` TEXT NOT NULL ,
        `count` MEDIUMINT( 10 ) NOT NULL
        ) ENGINE = InnoDB;");
        $this->execute("ALTER TABLE `shop__product_items` ADD CONSTRAINT `fk_product_item_product` FOREIGN KEY ( `product_id` ) REFERENCES `shop__product` ( `product_id` ) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("ALTER TABLE `shop__product_items` CHANGE `attributes` `properties` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ");
	}

	public function down()
	{
		echo "m120430_092750_shop__product_eav_text_values does not support migration down.\n";
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