<?php

class m120116_144414_change_shop_product_attribute_set_map extends CDbMigration
{
    private $_table = 'shop_product_attribute_set_map';

	public function up()
	{
        $this->dropIndex('map_set_id', $this->_table);
        $this->addColumn($this->_table, 'pos', 'tinyint');
	}

	public function down()
	{
        $this->dropColumn($this->_table, 'pos');
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