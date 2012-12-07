<?php

class m121205_111433_add_service_used extends CDbMigration
{
    private $_table = 'service_categories';

	public function up()
	{
        $this->renameTable($this->_table, 'services__categories');

        $this->_table = 'services__users';
        $this->createTable($this->_table, array(
            'user_id'=>'int(11) unsigned NOT NULL',
            'service_id' => 'int(11) unsigned NOT NULL',
            'use_time'=>'timestamp',
            'PRIMARY KEY (`user_id`, `service_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_service', $this->_table, 'service_id', 'services', 'id','CASCADE',"CASCADE");
        $this->createIndex($this->_table.'_use_time', $this->_table, 'use_time');

        $this->_table = 'services';
        $this->addColumn($this->_table, 'using_count', 'int not null default 0');
	}

	public function down()
	{
		echo "m121205_111433_add_service_used does not support migration down.\n";
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