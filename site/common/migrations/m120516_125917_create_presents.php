<?php

class m120516_125917_create_presents extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `happy_giraffe`.`shop__presents` (
        `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `product_id` INT( 10 ) UNSIGNED NOT NULL ,
        `present_id` INT( 10 ) UNSIGNED NOT NULL ,
        `count` INT NOT NULL ,
        `price` INT NOT NULL
        ) ENGINE = InnoDB;");
        $this->execute("ALTER TABLE `shop__presents`
          ADD CONSTRAINT `fk_present_product` FOREIGN KEY (`product_id`) REFERENCES `shop__product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `shop__presents`
          ADD CONSTRAINT `fk_present_present` FOREIGN KEY ( `present_id` ) REFERENCES `shop__product_items` ( `id` ) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->execute("ALTER TABLE `shop__presents` CHANGE `count` `count` INT( 11 ) NULL ,
        CHANGE `price` `price` INT( 11 ) NULL ");
        $this->execute("ALTER TABLE `shop__presents` CHANGE `price` `price` DECIMAL( 10, 2 ) NULL DEFAULT NULL ");

	}

	public function down()
	{
		echo "m120516_125917_create_presents does not support migration down.\n";
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