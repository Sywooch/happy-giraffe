<?php

class m111222_093604_product_dimensions extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `shop_product` ADD COLUMN `length` DOUBLE(9,2) NULL  AFTER `product_status` , ADD COLUMN `width` DOUBLE(9,2) NULL  AFTER `length` , ADD COLUMN `height` DOUBLE(9,2) NULL  AFTER `width` , ADD COLUMN `weight` DOUBLE(9,2) NULL  AFTER `height` ;
		";
		$this->execute($sql);
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