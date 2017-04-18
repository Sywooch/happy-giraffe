<?php

class m170417_105926_create_frame_partners extends CDbMigration
{
    private $_table = 'frame_partners';

    public function up()
	{
        $this->createTable($this->_table, array(
            'id'=>'int(11) NOT NULL AUTO_INCREMENT',
            'type' => 'char(11) NOT NULL',
            'description' => 'text NULL',
            'key' => 'varchar(255) NOT NULL',
            'updated'=>'TIMESTAMP NOT NULL',
	        'created' => 'TIMESTAMP NOT NULL',
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