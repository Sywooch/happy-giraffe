<?php

class m120713_093531_add_indexing extends CDbMigration
{
    private $_table = 'indexing__urls';
	public function up()
	{
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'url' => 'varchar(1024) NOT NULL',
            'active'=>'tinyint(1) not null default 0',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'indexing__up_dates';
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'date' => 'date NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'indexing__up_urls';
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'up_id' => 'date NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
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