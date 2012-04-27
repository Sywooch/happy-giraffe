<?php

class m120425_110445_create_product_images extends CDbMigration
{
	public function up()
	{
        $this->execute("
        CREATE TABLE IF NOT EXISTS `shop__product_images` (
          `id` int(10) unsigned NOT NULL,
          `product_id` int(10) unsigned NOT NULL,
          `photo_id` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          KEY `product_id` (`product_id`,`photo_id`),
          KEY `fk_product_photo` (`photo_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("ALTER TABLE `shop__product_images`
          ADD CONSTRAINT `fk_product_photo` FOREIGN KEY (`photo_id`) REFERENCES `album__photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `fk_product_product` FOREIGN KEY (`product_id`) REFERENCES `shop__product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `shop__product_images` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
        $this->execute("ALTER TABLE `shop__product_images` ADD `type` BOOLEAN NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m120425_110445_create_product_images does not support migration down.\n";
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