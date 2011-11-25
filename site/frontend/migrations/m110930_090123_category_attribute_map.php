<?php

class m110930_090123_category_attribute_map extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE shop_category_attributes_map (
	map_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	map_category_id INT(10) UNSIGNED NOT NULL,
	map_attribute_id INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (map_id),
	UNIQUE INDEX map_category_id (map_category_id, map_attribute_id)
)
COMMENT='Привязка атрибутов к категориям'
COLLATE='utf8_general_ci'
ENGINE=MyISAM;");
	}

	public function down()
	{
		echo "m110930_090123_category_attribute_map does not support migration down.\n";
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