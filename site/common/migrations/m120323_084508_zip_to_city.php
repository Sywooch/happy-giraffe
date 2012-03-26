<?php

class m120323_084508_zip_to_city extends CDbMigration
{
    private $_table = 'geo__zip';

    public function up()
    {
        $this->createTable('geo__zip', array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'code' => 'varchar(50) NOT NULL',
            'city_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_'.$this->_table.'_city', $this->_table, 'city_id', 'geo__city', 'id','CASCADE',"CASCADE");

        $this->_table = 'geo__region';
        $this->addForeignKey('fk_'.$this->_table.'_country', $this->_table, 'country_id', 'geo__country', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
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