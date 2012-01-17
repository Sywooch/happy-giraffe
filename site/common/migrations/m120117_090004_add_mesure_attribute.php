<?php

class m120117_090004_add_mesure_attribute extends CDbMigration
{
    private $_table = 'shop_product_attribute_measure';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'title' => 'varchar(256)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'shop_product_attribute_measure_option';
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'measure_id' => 'int',
                'title' => 'varchar(256)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table . '_measure_fk', $this->_table, 'measure_id', 'shop_product_attribute_measure',
            'id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_attribute';
        $this->addColumn($this->_table, 'measure_option_id', 'int');
    }

    public function down()
    {
        $this->_table = 'shop_product_attribute_measure_option';
        $this->dropForeignKey($this->_table . '_measure_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'shop_product_attribute_measure';
        $this->dropTable($this->_table);
    }
}