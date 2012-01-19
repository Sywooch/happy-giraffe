<?php

class m120119_071035_active extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `shop_product_brand` ADD `active` BOOLEAN NOT NULL ;
ALTER TABLE `shop_category` ADD `active` BOOLEAN NOT NULL ;");
	}

	public function down()
	{
		echo "m120119_071035_active does not support migration down.\n";
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