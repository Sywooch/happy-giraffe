<?php

class m120326_100325_user_address extends CDbMigration
{
    private $_table = 'user_address';

    public function up()
    {
        $this->createTable($this->_table, array(
            'user_id' => 'int(10) unsigned NOT NULL',
            'country_id' => 'int(11) unsigned',
            'region_id' => 'int(11) unsigned',
            'city_id' => 'int(11) unsigned',
            'street_id' => 'int(11) unsigned',
            'house' => 'varchar(10)',
            'room' => 'varchar(10)',
            'manual' => 'varchar(256)',
            'PRIMARY KEY (`user_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_country', $this->_table, 'country_id', 'geo__country', 'id', 'SET NULL', "SET NULL");
        $this->addForeignKey('fk_' . $this->_table . '_region', $this->_table, 'region_id', 'geo__region', 'id', 'SET NULL', "SET NULL");
        $this->addForeignKey('fk_' . $this->_table . '_city', $this->_table, 'city_id', 'geo__city', 'id', 'SET NULL', "SET NULL");

        $this->update('user', array(
            'country_id'=>null,
            'settlement_id'=>null,
            'street_id'=>null,
            'house'=>null,
            'room'=>null,
        ));
        $this->_table = 'user';
        $this->execute('
        SET foreign_key_checks = 0;
        ALTER TABLE user DROP FOREIGN KEY user_country_fk;
        ALTER TABLE user DROP FOREIGN KEY user_settlement_fk;
        ALTER TABLE user DROP FOREIGN KEY user_street_fk;

        ALTER TABLE user DROP country_id;
        ALTER TABLE user DROP settlement_id;
        ALTER TABLE user DROP street_id;
        ALTER TABLE user DROP house;
        ALTER TABLE user DROP room;
        SET foreign_key_checks = 1;
        ');
    }

    public function down()
    {
        echo "m120326_100325_user_address does not support migration down.\n";
        return false;
    }
}