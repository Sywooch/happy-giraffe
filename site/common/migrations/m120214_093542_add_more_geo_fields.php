<?php

class m120214_093542_add_more_geo_fields extends CDbMigration
{
    private $_table = 'user';

    public function up()
    {
        $this->addColumn($this->_table, 'street_id', 'int unsigned after settlement_id');
        $this->addForeignKey($this->_table . '_street_fk', $this->_table, 'street_id', 'geo_rus_street', 'id', 'CASCADE', "CASCADE");
        $this->addColumn($this->_table, 'house', 'varchar(256) after street_id');
        $this->addColumn($this->_table, 'room', 'varchar(256) after house');
        $this->update($this->_table, array('settlement_id' => null));
        $this->addForeignKey($this->_table . '_settlement_fk', $this->_table, 'settlement_id', 'geo_rus_settlement', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'geo_rus_settlement';
        $this->addColumn($this->_table, 'by_user', 'tinyint(1) default 0');
        $this->_table = 'geo_rus_street';
        $this->addColumn($this->_table, 'by_user', 'tinyint(1) default 0');
    }

    public function down()
    {
        $this->dropForeignKey($this->_table . '_street_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_settlement_fk', $this->_table);
        $this->dropColumn($this->_table, 'street_id');
        $this->dropColumn($this->_table, 'house');
        $this->dropColumn($this->_table, 'room');

        $this->_table = 'geo_rus_settlement';
        $this->dropColumn($this->_table, 'by_user');
        $this->_table = 'geo_rus_street';
        $this->dropColumn($this->_table, 'by_user');
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