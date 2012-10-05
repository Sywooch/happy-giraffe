<?php

class m121005_061330_parseSiteResults extends CDbMigration
{
    private $_table = 'yandex_search_results';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'keyword_id' => 'int(11) NOT NULL',
            'page_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_page', $this->_table, 'page_id', 'pages', 'id', 'CASCADE', "CASCADE");


        $this->_table = 'yandex_search_keywords';
        $this->createTable($this->_table, array(
            'keyword_id' => 'int(11) NOT NULL',
            'active' => 'tinyint(1) NOT NULL default 0',
            'PRIMARY KEY (`keyword_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        echo "m121005_061330_parseSiteResults does not support migration down.\n";
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