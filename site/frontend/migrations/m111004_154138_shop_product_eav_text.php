<?php
class m111004_154138_shop_product_eav_text extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE shop_product_eav_text (
	eav_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	eav_product_id INT(10) UNSIGNED NOT NULL,
	eav_attribute_id INT(10) UNSIGNED NOT NULL,
	eav_attribute_value TEXT NULL,
	PRIMARY KEY (eav_id),
	INDEX eav_product_id (eav_product_id, eav_attribute_id)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;");
		
		
	}
	

	public function down()
	{
		echo "m111004_154138_shop_product_eav_text does not support migration down.\n";
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
