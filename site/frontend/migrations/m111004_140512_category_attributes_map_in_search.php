<?php
class m111004_140512_category_attributes_map_in_search extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_category_attributes_map
	ADD COLUMN map_in_search TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER map_attribute_id;
");
		
		
	}
	

	public function down()
	{
		echo "m111004_140512_category_attributes_map_in_search does not support migration down.\n";
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
