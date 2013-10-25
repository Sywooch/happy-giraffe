<?php

class m130808_125609_giraffe_traffic extends CDbMigration
{
    private $_table = 'giraffe_last_month_traffic';

    public function up()
    {
        $this->createTable($this->_table, array(
            'keyword_id' => 'int(11) NOT NULL',
            'value' => 'int(11) unsigned NOT NULL',
            'active' => 'int(1) unsigned NOT NULL default 0',
            'PRIMARY KEY (`keyword_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_keyword', $this->_table, 'keyword_id', 'keywords.keywords', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey('fk_'.$this->_table . '_keyword', $this->_table);
        $this->dropTable($this->_table);
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