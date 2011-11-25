<?php
class m111005_111449_product_brand_id extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product
	ADD COLUMN product_brand_id INT(10) UNSIGNED NOT NULL AFTER product_category_id;");
	}

	public function down()
	{
		echo "m111005_111449_product_brand_id does not support migration down.\n";
		return false;
		
		$this->execute("");
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
