<?php

class m120910_064539_external_links extends CDbMigration
{
    private $_table = 'externalLinks__sites';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'url' => 'varchar(255) NOT NULL',
            'type' => 'tinyint unsigned NOT NULL default 0',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'externalLinks__links';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'site_id' => 'int(11) unsigned NOT NULL',
            'url' => 'varchar(2048) NOT NULL',
            'our_link' => 'varchar(255) NOT NULL',
            'author_id' => 'int(11) unsigned NOT NULL',
            'date' => 'timespan NOT NULL',
            'link_type' => 'tinyint unsigned NOT NULL',
            'link_cost' => 'tinyint unsigned NOT NULL',
            'system_id' => 'tinyint unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m120910_064539_external_links does not support migration down.\n";
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