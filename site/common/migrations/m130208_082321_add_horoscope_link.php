<?php

class m130208_082321_add_horoscope_link extends CDbMigration
{
    private $_table = 'services__horoscope_links';

	public function up()
	{
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'horoscope_id' => 'int NOT NULL',
            'today_link' => 'tinyint',
            'tomorrow_link' => 'tinyint',
            'month_link' => 'tinyint',
            'some_month' => 'tinyint',
            'some_month_link' => 'tinyint',
            'year_link' => 'tinyint',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_horoscope', $this->_table, 'horoscope_id', 'services__horoscope', 'id','CASCADE',"CASCADE");
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