<?php

class m120621_074833_search_phrases extends CDbMigration
{
    private $_table = 'pages_search_phrases';

    public function up()
    {
        $this->renameTable('article_keywords', 'pages');
        $this->dropTable('query_visits');

        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'page_id' => 'int(11) unsigned NOT NULL',
            'keyword_id' => 'int(11) NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_page', $this->_table, 'page_id', 'pages', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'pages_search_phrases_positions';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'search_phrase_id' => 'int(11) unsigned NOT NULL',
            'se_id' => 'int(11) unsigned NOT NULL',
            'position' => 'mediumint unsigned NOT NULL',
            'date' => 'date NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_search_phrase', $this->_table, 'search_phrase_id', 'pages_search_phrases', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'pages_search_phrases_visits';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'search_phrase_id' => 'int(11) unsigned NOT NULL',
            'se_id' => 'int(11) unsigned NOT NULL',
            'visits' => 'mediumint unsigned NOT NULL',
            'week' => 'tinyint NOT NULL',
            'year' => 'smallint NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_search_phrase', $this->_table, 'search_phrase_id', 'pages_search_phrases', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        echo "m120621_074833_search_phrases does not support migration down.\n";
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