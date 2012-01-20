<?php

class m120120_090151_add_category_set_map extends CDbMigration
{
    private $_table = 'shop_category_attribute_set_map';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'category_id' => 'int UNSIGNED not null',
                'attribute_set_id' => 'int UNSIGNED not null',
                'PRIMARY KEY (category_id, attribute_set_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table . '_category_fk', $this->_table, 'category_id',
            'shop_category', 'category_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_attribute_set_fk', $this->_table, 'attribute_set_id',
            'shop_product_attribute_set', 'set_id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey($this->_table . '_category_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_attribute_set_fk', $this->_table);
        $this->dropTable($this->_table);
    }
}