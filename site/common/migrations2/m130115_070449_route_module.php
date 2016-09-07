<?php

class m130115_070449_route_module extends CDbMigration
{
    private $_table = 'routes__routes';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'city_from_id' => 'int(11) UNSIGNED NOT NULL',
            'city_to_id' => 'int(11) UNSIGNED NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_city_from', $this->_table, 'city_from_id', 'geo__city', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_city_to', $this->_table, 'city_to_id', 'geo__city', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'routes__links';

        $this->createTable($this->_table,
            array(
                'route_from_id' => 'int(11) UNSIGNED NOT NULL',
                'route_to_id' => 'int(11) UNSIGNED NOT NULL',
                'anchor' => 'varchar(255) NOT NULL',
                'PRIMARY KEY (route_from_id, route_to_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_route_from', $this->_table, 'route_from_id', 'routes__routes', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_route_to', $this->_table, 'route_to_id', 'routes__routes', 'id', 'CASCADE', "CASCADE");

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