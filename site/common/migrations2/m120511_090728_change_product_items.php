<?php

class m120511_090728_change_product_items extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `shop__product_items` ADD `price` DECIMAL NOT NULL ");
        $this->execute("ALTER TABLE `shop__product_items` CHANGE `price` `price` DECIMAL( 10, 2 ) NOT NULL ");
	}

	public function down()
	{
		echo "m120511_090728_change_product_items does not support migration down.\n";
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