<?php

class m130815_080140_add_avatar_source extends CDbMigration
{
    private $_table = 'user__avatars';

    public function up()
    {
        $this->createTable($this->_table, array(
            'avatar_id' => 'int(11) unsigned NOT NULL',
            'source_id' => 'int(11) unsigned NOT NULL',
            'x' => 'SMALLINT UNSIGNED NOT NULL',
            'y' => 'SMALLINT UNSIGNED NOT NULL',
            'w' => 'SMALLINT UNSIGNED NOT NULL',
            'h' => 'SMALLINT UNSIGNED NOT NULL',
            'PRIMARY KEY (`avatar_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_avatar', $this->_table, 'avatar_id', 'album__photos', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_source', $this->_table, 'source_id', 'album__photos', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
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