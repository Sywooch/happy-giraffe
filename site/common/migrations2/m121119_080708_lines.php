<?php

class m121119_080708_lines extends CDbMigration
{
    private $_table = 'services__lines';

	public function up()
	{
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'type' => 'tinyint NOT NULL',
            'image_id' => 'int NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'date' => 'date NOT NULL',
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