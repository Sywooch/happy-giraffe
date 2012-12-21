<?php

class m121221_133053_add_folders extends CDbMigration
{
    private $_table = 'keywords__folders';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'user_id' => 'int(11) unsigned NOT NULL',
            'name' => 'varchar(100) NOT NULL',
            'color' => 'tinyint NOT NULL default 0',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'users', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'keywords__folders_keywords';
        $this->createTable($this->_table,
            array(
                'keyword_id' => 'int(11) not null',
                'folder_id' => 'int(11) unsigned not null',
                'PRIMARY KEY (keyword_id, folder_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_folder', $this->_table, 'folder_id', 'keywords__folders', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        echo "m121221_133053_add_folders does not support migration down.\n";
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