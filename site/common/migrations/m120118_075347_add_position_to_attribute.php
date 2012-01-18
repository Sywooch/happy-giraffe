<?php

class m120118_075347_add_position_to_attribute extends CDbMigration
{
    private $_table = 'shop_product_attribute_set_map';
	public function up()
	{
        $this->alterColumn($this->_table, 'pos', 'int default 0 not null');
        $this->_table = 'shop_product_attribute_set';
        $this->addColumn($this->_table, 'brand_pos', 'int default 0 not null');
	}

	public function down()
	{
        $this->_table = 'shop_product_attribute_set';
        $this->dropColumn($this->_table, 'brand_pos');
	}
}