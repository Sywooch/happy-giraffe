<?php

class m110919_105227_map_set_product_count extends CDbMigration
{
	public function up()
	{
		$sql = "ALTER TABLE `shop_product_set_map`
	ADD COLUMN `map_product_count` TINYINT UNSIGNED NOT NULL AFTER `map_product_id`";

		$this->execute($sql);
	}

	public function down()
	{
		$sql = "ALTER TABLE `shop_product_set_map`
	DROP COLUMN `map_product_count`";

		$this->execute($sql);
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