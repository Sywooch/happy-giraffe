<?php

class m130618_170843_subscriptions extends CDbMigration
{
    private $_table = '';

    public function up()
    {
        $this->_table = 'user__community_subscriptions';
        $this->createTable($this->_table, array(
            'user_id' => 'int(10) unsigned NOT NULL',
            'community_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`user_id`, `community_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_community', $this->_table, 'community_id', 'community__communities', 'id','CASCADE',"CASCADE");

        $this->_table = 'user__blog_subscriptions';
        $this->createTable($this->_table, array(
            'user_id' => 'int(10) unsigned NOT NULL',
            'user2_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`user_id`, `user2_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_user2', $this->_table, 'user2_id', 'users', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m130618_170843_subscriptions does not support migration down.\n";
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