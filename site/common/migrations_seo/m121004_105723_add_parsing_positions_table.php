<?php

class m121004_105723_add_parsing_positions_table extends CDbMigration
{
    private $_table = 'parsing_positions';

	public function up()
	{
        $this->createTable($this->_table, array(
            'keyword_id'=>'int(11) NOT NULL',
            'active' => 'tinyint(1) NOT NULL default 0',
            'yandex' => 'tinyint(1) NOT NULL default 0',
            'google' => 'tinyint(1) NOT NULL default 0',
            'PRIMARY KEY (`keyword_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_keyword', $this->_table, 'keyword_id', 'keywords', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m121004_105723_add_parsing_positions_table does not support migration down.\n";
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