<?php

class m120625_083121_edit_linking_tables extends CDbMigration
{
    private $_table = 'linking_pages_pages';

    public function up()
    {
//        $this->dropTable($this->_table);
//        $this->_table = 'linking_pages';
//        $this->dropTable($this->_table);

        $this->_table = 'inner_links';
        $this->createTable($this->_table, array(
            'page_id' => 'int(10) UNSIGNED NOT NULL',
            'phrase_id' => 'int(10) UNSIGNED NOT NULL',
            'page_to_id' => 'int(10) UNSIGNED NOT NULL',
            'keyword_id' => 'int(10) NOT NULL',
            'date' => 'date not null',
            'PRIMARY KEY (`page_id`, `page_to_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_page', $this->_table, 'page_id', 'pages', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_page_to', $this->_table, 'page_to_id', 'pages', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_keyword', $this->_table, 'keyword_id', 'keywords', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_phrase', $this->_table, 'phrase_id', 'pages_search_phrases', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m120625_083121_edit_linking_tables does not support migration down.\n";
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