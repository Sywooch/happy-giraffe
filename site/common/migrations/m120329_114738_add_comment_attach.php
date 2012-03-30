<?php

class m120329_114738_add_comment_attach extends CDbMigration
{
    private $_table = 'comment_attaches';

	public function up()
	{
        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'comment_id' => 'int(11) unsigned NOT NULL',
            'entity' => 'varchar(255) NOT NULL',
            'entity_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_comment', $this->_table, 'comment_id', 'comment', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m120329_114738_add_comment_attach does not support migration down.\n";
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