<?php

class m130204_105820_add_route_feature extends CDbMigration
{
    private $_table = 'auth__items';

    public function up()
    {
        $this->insert($this->_table, array(
            'name' => 'routes',
            'type' => 0,
            'description' => 'Редактирование сервиса маршрутов',
        ));

        $this->_table = 'routes__fuel_cost';
        $this->createTable($this->_table, array(
            'currency_id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'currency_name' => 'varchar(20) NOT NULL',
            'cost' => 'float',
            'PRIMARY KEY (`currency_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->execute("INSERT INTO `routes__fuel_cost` (`currency_id`, `currency_name`, `cost`) VALUES (1, 'руб.', 28),(2, '$', 1),(3, '€', 1.7),(4, '₴', 10.5),(5, 'тенге', 110),(6, 'BYR', 7400);");
    }

    public function down()
    {
        echo "m130204_105820_add_route_feature does not support migration down.\n";
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