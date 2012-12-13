<?php

class m121207_093303_add_user_priority extends CDbMigration
{
    private $_table = 'user__priority';

    public function up()
    {
        $this->createTable($this->_table, array(
            'user_id' => 'int(11) unsigned NOT NULL',
            'priority' => 'tinyint NOT NULL default 10',
            'PRIMARY KEY (`user_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'users', 'id', 'CASCADE', "CASCADE");
        $this->createIndex($this->_table . '_priority', $this->_table, 'priority');
    }

    public function down()
    {
        echo "m121207_093303_add_user_priority does not support migration down.\n";
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