<?php

class m130214_051736_route_coordinates extends CDbMigration
{
    private $_table = 'routes__coordinates';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'lat' => 'float(10,7) not null',
            'lng' => 'float(10,7) not null',
            'city_id' => 'int UNSIGNED',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_city', $this->_table, 'city_id', 'geo__city', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        $this->dropTable($this->_table);
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