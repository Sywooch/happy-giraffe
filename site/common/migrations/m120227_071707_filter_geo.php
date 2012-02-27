<?php

class m120227_071707_filter_geo extends CDbMigration
{
    private $_table = 'geo__filter_parts';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'part' => 'varchar(64)',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->insert($this->_table, array('part'=>'село'));
        $this->insert($this->_table, array('part'=>'с.'));
        $this->insert($this->_table, array('part'=>'город'));
        $this->insert($this->_table, array('part'=>'г.'));
        $this->insert($this->_table, array('part'=>'деревня'));
        $this->insert($this->_table, array('part'=>'д.'));
        $this->insert($this->_table, array('part'=>'поселок'));
        $this->insert($this->_table, array('part'=>'п.'));
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }
}