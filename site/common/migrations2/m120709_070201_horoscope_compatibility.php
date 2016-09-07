<?php

class m120709_070201_horoscope_compatibility extends CDbMigration
{
    private $_table = 'services__horoscope_compatibility';

	public function up()
	{
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'zodiac1' => 'tinyint NOT NULL',
            'zodiac2' => 'tinyint NOT NULL',
            'text' => 'text',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		echo "m120709_070201_horoscope_compatibility does not support migration down.\n";
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