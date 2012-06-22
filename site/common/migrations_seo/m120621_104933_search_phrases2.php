<?php

class m120621_104933_search_phrases2 extends CDbMigration
{
    private $_table = 'query_pages';

    public function up()
    {
        $this->dropTable($this->_table);

        $this->_table = 'query_search_engines';
        $this->dropForeignKey('fk_'.$this->_table . '_session', $this->_table);
        $this->dropColumn($this->_table, 'session_id');

        $this->_table = 'queries';
        $this->addColumn($this->_table, 'week', 'tinyint');
        $this->addColumn($this->_table, 'year', 'smallint');

        $this->_table = 'yandex_rank';
        $this->dropTable($this->_table);

        $this->_table = 'parsing_sessions';
        $this->dropTable($this->_table);

        $this->_table = 'queries';
        $this->truncateTable('queries');
        $this->dropColumn($this->_table,'phrase');
        $this->addColumn($this->_table, 'keyword_id', 'int not null after id');
        $this->addForeignKey('fk_'.$this->_table.'_keyword', $this->_table, 'keyword_id', 'keywords', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m120621_104933_search_phrases2 does not support migration down.\n";
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