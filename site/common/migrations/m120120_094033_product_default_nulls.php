<?php

class m120120_094033_product_default_nulls extends CDbMigration
{
    private $_table = 'shop_product';

	public function up()
	{
        $this->alterColumn($this->_table, 'product_age_range_id', 'int(10) UNSIGNED NULL');
        $this->alterColumn($this->_table, 'product_sex', 'int(10) UNSIGNED NULL');
        $this->alterColumn($this->_table, 'product_brand_id', 'int(10) UNSIGNED NULL');
        $this->alterColumn($this->_table, 'product_price', 'decimal(10,2) default 0');
        $this->alterColumn($this->_table, 'product_buy_price', 'decimal(10,2) default 0');
        $this->alterColumn($this->_table, 'product_sell_price', 'decimal(10,2) default 0');
        $this->alterColumn($this->_table, 'product_slug', 'varchar(150) default ""');
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