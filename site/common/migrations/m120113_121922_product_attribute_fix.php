<?php

class m120113_121922_product_attribute_fix extends CDbMigration
{
    private $_table = 'shop_product_attribute';

    public function up()
    {
        $this->addColumn($this->_table, 'price_influence', 'tinyint(1) default 0 not null');

        $this->_table = 'shop_product_price';
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'product_id'=>'int(10) UNSIGNED not null',
                'attribute_id'=>'int(10) UNSIGNED not null',
                'attribute_value_id'=>'int(10) UNSIGNED not null',
                'product_price' => 'decimal(10,2) not null',
                'product_buy_price' => 'decimal(10,2) not null',
                'product_sell_price' => 'decimal(10,2) not null',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        $this->dropColumn($this->_table, 'price_influence');
        $this->_table = 'shop_product_price';
        $this->dropTable($this->_table);
    }
}