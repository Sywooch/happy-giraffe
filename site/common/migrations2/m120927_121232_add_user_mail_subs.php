<?php

class m120927_121232_add_user_mail_subs extends CDbMigration
{
    private $_table = 'user__mail_subs';
	public function up()
	{
        $this->createTable($this->_table, array(
            'user_id'=>'int(11) unsigned NOT NULL',
            'weekly_news' => 'tinyint(1) default 1 NOT NULL',
            'new_messages' => 'tinyint(1) default 1 NOT NULL',
            'PRIMARY KEY (`user_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m120927_121232_add_user_mail_subs does not support migration down.\n";
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