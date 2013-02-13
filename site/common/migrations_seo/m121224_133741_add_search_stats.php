<?php

class m121224_133741_add_search_stats extends CDbMigration
{
    private $_table = 'statistic__user_search';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'user_id' => 'int(11) unsigned NOT NULL',
            'keyword_id' => 'int(11) not null',
            'created' => 'timestamp',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'users', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'statistic__user_actions';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'user_id' => 'int(11) unsigned NOT NULL',
            'keyword_id' => 'int(11) not null',
            'action_id' => 'tinyint not null',
            'created' => 'timestamp',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'users', 'id', 'CASCADE', "CASCADE");

    }

    public function down()
    {
        echo "m121224_133741_add_search_stats does not support migration down.\n";
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