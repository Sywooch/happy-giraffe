<?php

class m111222_093604_product_dimensions extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `giraffe`.`shop_product` ADD COLUMN `length` DOUBLE(9,2) NULL  AFTER `product_status` , ADD COLUMN `width` DOUBLE(9,2) NULL  AFTER `length` , ADD COLUMN `height` DOUBLE(9,2) NULL  AFTER `width` , ADD COLUMN `weight` DOUBLE(9,2) NULL  AFTER `height` ;
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m111222_093604_product_dimensions does not support migration down.\n";
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