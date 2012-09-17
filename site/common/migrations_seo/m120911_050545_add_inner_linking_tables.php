<?php

class m120911_050545_add_inner_linking_tables extends CDbMigration
{
    private $_table = 'inner_linking__skips';

    public function up()
    {
        $this->createTable($this->_table, array(
            'phrase_id' => 'int(11) unsigned NOT NULL',
            'date' => 'datetime not null',
            'PRIMARY KEY (`phrase_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_phrase', $this->_table, 'phrase_id', 'pages_search_phrases', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'inner_linking__urls';

        $this->createTable($this->_table, array(
            'id'=>'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'keyword_id' => 'int(11) NOT NULL',
            'url' => 'varchar(255) not null',
            'created' => 'datetime not null',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_'.$this->_table.'_keyword', $this->_table, 'keyword_id', 'keywords', 'id','CASCADE',"CASCADE");

        $this->renameTable('inner_links', 'inner_linking__links');

        $this->_table = 'pages_search_phrases';
        $this->addColumn($this->_table, 'last_yandex_position', 'int unsigned default 1000');
        $this->addColumn($this->_table, 'google_traffic', 'int unsigned default 0');
    }

    public function down()
    {
        echo "m120911_050545_add_inner_linking_tables does not support migration down.\n";
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