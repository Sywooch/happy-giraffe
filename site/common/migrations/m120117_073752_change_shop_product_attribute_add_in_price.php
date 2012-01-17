<?php

class m120117_073752_change_shop_product_attribute_add_in_price extends CDbMigration
{
    private $_table = 'shop_product_attribute';

	public function up()
	{
        $this->addColumn($this->_table, 'attribute_in_price', 'tinyint(1) default 0');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'attribute_in_price');
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