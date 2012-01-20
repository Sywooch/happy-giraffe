<?php

class m120120_062009_shop_tables_to_innodb extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `shop_category` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_category_attributes_map` ENGINE = INNODB');

        $this->execute('ALTER TABLE  `shop_product` ENGINE = INNODB');

        $this->execute('ALTER TABLE  `shop_product_attribute` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_attribute_measure` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_attribute_measure_option` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_attribute_set` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_attribute_set_map` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_attribute_value` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_attribute_value_map` ENGINE = INNODB');

        $this->execute('ALTER TABLE  `shop_product_brand` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_comment` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_eav` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_eav_text` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_image` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_link` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_price` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_pricelist` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_pricelist_set_map` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_set` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_set_map` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_type` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_product_video` ENGINE = INNODB');

        $this->execute('ALTER TABLE  `shop_vaucher` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `shop_vaucher_use` ENGINE = INNODB');
	}

	public function down()
	{

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