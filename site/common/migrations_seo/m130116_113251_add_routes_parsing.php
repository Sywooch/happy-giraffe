<?php

class m130116_113251_add_routes_parsing extends CDbMigration
{
    private $_table = 'route_parsing';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'city_from_id' => 'int(11) UNSIGNED NOT NULL',
            'city_to_id' => 'int(11) UNSIGNED NOT NULL',
            'wordstat' => 'int(11)',
            'active' => 'tinyint(2) not null default 0',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
    }

    public function down()
    {

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