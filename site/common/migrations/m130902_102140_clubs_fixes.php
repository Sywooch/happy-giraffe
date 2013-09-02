<?php

class m130902_102140_clubs_fixes extends CDbMigration
{
    private $_table = 'community__sections';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(255) NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'community__clubs';
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'title' => 'varchar(255) NOT NULL',
            'description' => 'varchar(1000)',
            'section_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_section', $this->_table, 'section_id', 'community__sections', 'id', 'CASCADE', "CASCADE");

        $this->renameTable('community__communities', 'community__forums');
        $this->_table = 'community__forums';
        $this->addColumn($this->_table, 'club_id', 'int(11) unsigned');
        $this->addForeignKey('fk_'.$this->_table.'_club', $this->_table, 'club_id', 'community__clubs', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m130902_102140_clubs_fixes does not support migration down.\n";
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