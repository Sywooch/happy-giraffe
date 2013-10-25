<?php

class m130628_053546_add_photo_post extends CDbMigration
{
    private $_table = 'community__photo_posts';

    public function up()
    {
        $this->createTable($this->_table, array(
            'content_id' => 'int(11) unsigned NOT NULL',
            'text' => 'text',
            'photo_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`content_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_' . $this->_table . '_content', $this->_table, 'content_id', 'community__contents', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_photo', $this->_table, 'photo_id', 'album__photos', 'id', 'CASCADE', "CASCADE");
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