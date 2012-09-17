<?php

class m120910_064539_external_links extends CDbMigration
{
    private $_table = 'auth__items';

    public function up()
    {
        $this->insert($this->_table, array('name' => 'externallinks-manager', 'type' => 2, 'description' => 'Шеф-редактор внешних ссылок'));
        $this->insert($this->_table, array('name' => 'externallinks-manager-panel', 'type' => 0, 'description' => 'Панель Шеф-редактора внешних ссылок'));
        $this->insert('auth__items_childs', array('parent' => 'externallinks-manager', 'child' => 'externallinks-manager-panel'));

        $this->insert($this->_table, array('name' => 'externallinks-worker', 'type' => 2, 'description' => 'Шеф-редактор внешних ссылок'));
        $this->insert($this->_table, array('name' => 'externallinks-worker-panel', 'type' => 0, 'description' => 'Панель Шеф-редактора внешних ссылок'));
        $this->insert('auth__items_childs', array('parent' => 'externallinks-worker', 'child' => 'externallinks-worker-panel'));

        $this->_table = 'externallinks__sites';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'url' => 'varchar(255) NOT NULL',
            'type' => 'tinyint unsigned NOT NULL default 0',
            'status' => 'tinyint unsigned NOT NULL default 1',
            'created' => 'datetime not null',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'externallinks__systems';
        $this->createTable($this->_table, array(
            'id' => 'tinyint unsigned NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(255) NOT NULL',
            'fee' => 'double NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'externallinks__links';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'site_id' => 'int(11) unsigned NOT NULL',
            'url' => 'varchar(2048) NOT NULL',
            'our_link' => 'varchar(255) NOT NULL',
            'author_id' => 'int(11) unsigned NOT NULL',
            'created' => 'datetime NOT NULL',
            'check_link_time' => 'datetime NOT NULL',
            'link_type' => 'tinyint unsigned NOT NULL',
            'link_cost' => 'double unsigned',
            'system_id' => 'tinyint unsigned',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_site', $this->_table, 'site_id', 'externallinks__sites', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_author', $this->_table, 'author_id', 'users', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_system', $this->_table, 'system_id', 'externallinks__systems', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'externallinks__anchors';
        $this->createTable($this->_table, array(
            'link_id' => 'int(11) unsigned NOT NULL',
            'keyword_id' => 'int(11) NOT NULL',
            'PRIMARY KEY (`link_id`, `keyword_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_link', $this->_table, 'link_id', 'externallinks__links', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'externallinks__accounts';
        $this->createTable($this->_table, array(
            'site_id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'login' => 'varchar(255) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'created' => 'datetime NOT NULL',
            'PRIMARY KEY (`site_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_site', $this->_table, 'site_id', 'externallinks__sites', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'externallinks__tasks';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'site_id' => 'int(11) unsigned NOT NULL',
            'type' => 'tinyint NOT NULL',
            'user_id' => 'int(11) unsigned',
            'created' => 'date NOT NULL',
            'start_date' => 'date NOT NULL',
            'closed' => 'datetime',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_site', $this->_table, 'site_id', 'externallinks__sites', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'users', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
//        echo "m120910_064539_external_links does not support migration down.\n";
//        return false;
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