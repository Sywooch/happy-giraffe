<?php

class m120322_095109_add_geo_district extends CDbMigration
{
    private $_table = 'geo__district';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int unsigned NOT NULL auto_increment',
            'name' => 'varchar(255) NOT NULL',
            'region_id' => 'int(11) unsigned',
            'capital_id' => 'int(11) unsigned',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_region', $this->_table, 'region_id', 'geo__region', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_capital', $this->_table, 'capital_id', 'geo__city', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'geo__city';
        $this->addColumn($this->_table, 'district_id', 'int(11) unsigned after id');
        $this->addForeignKey('fk_' . $this->_table . '_district', $this->_table, 'district_id', 'geo__district', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_region', $this->_table, 'region_id', 'geo__region', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_country', $this->_table, 'country_id', 'geo__country', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        echo "m120322_095109_add_geo_district does not support migration down.\n";
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