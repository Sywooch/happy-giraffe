<?php

class m120120_064925_add_product_attributes_fks extends CDbMigration
{
    private $_table = 'shop_product_attribute';

    public function up()
    {
        $this->execute('SET foreign_key_checks = 0;');
        $this->addForeignKey($this->_table . '_measure_option_fk', $this->_table, 'measure_option_id', 'shop_product_attribute_measure_option', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_attribute_set_map';
        $this->addForeignKey($this->_table . '_map_set_fk', $this->_table, 'map_set_id', 'shop_product_attribute_set', 'set_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_map_attribute_fk', $this->_table, 'map_attribute_id', 'shop_product_attribute', 'attribute_id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_attribute_value_map';
        $this->addForeignKey($this->_table . '_map_attribute_fk', $this->_table, 'map_attribute_id', 'shop_product_attribute', 'attribute_id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_map_value_fk', $this->_table, 'map_value_id', 'shop_product_attribute_value', 'value_id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_eav';
        $this->addForeignKey($this->_table . '_map_attribute_fk', $this->_table, 'eav_attribute_id', 'shop_product_attribute', 'attribute_id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_eav_text';
        $this->addForeignKey($this->_table . '_map_attribute_fk', $this->_table, 'eav_attribute_id', 'shop_product_attribute', 'attribute_id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_type';
        $this->addForeignKey($this->_table . '_type_attribute_set_fk', $this->_table, 'type_attribute_set_id', 'shop_product_attribute_set', 'set_id', 'CASCADE', "CASCADE");

        $this->_table = 'shop_product_attribute_value';
        $this->dropIndex('value_value', $this->_table);

        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0;');

        $this->dropForeignKey($this->_table . '_measure_option_fk', $this->_table);

        $this->_table = 'shop_product_attribute_set_map';
        $this->dropForeignKey($this->_table . '_map_set_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_map_attribute_fk', $this->_table);

        $this->_table = 'shop_product_attribute_value_map';
        $this->dropForeignKey($this->_table . '_map_attribute_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_map_value_fk', $this->_table);

        $this->_table = 'shop_product_eav';
        $this->dropForeignKey($this->_table . '_map_attribute_fk', $this->_table);

        $this->_table = 'shop_product_eav_text';
        $this->dropForeignKey($this->_table . '_map_attribute_fk', $this->_table);

        $this->_table = 'shop_product_type';
        $this->dropForeignKey($this->_table . '_type_attribute_set_fk', $this->_table);

        $this->_table = 'shop_product_attribute_value';
        $this->execute('CREATE INDEX value_value ON '.$this->_table.' (value_value);');

        $this->execute('SET foreign_key_checks = 1;');
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