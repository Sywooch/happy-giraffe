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

        $this->_table = 'indexing__ups';
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'date' => 'date NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'indexing__up_urls';
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'up_id' => 'int(11) unsigned NOT NULL',
            'url_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_'.$this->_table.'_up', $this->_table, 'up_id', 'indexing__ups', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_url', $this->_table, 'url_id', 'indexing__urls', 'id','CASCADE',"CASCADE");
    }

	public function down()
	{
        $this->_table = 'indexing__up_urls';
		$this->dropTable($this->_table);
        $this->_table = 'indexing__ups';
        $this->dropTable($this->_table);
        $this->_table = 'indexing__urls';
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