<?php

class m121030_125955_add_video_preview extends CDbMigration
{
    private $_table = 'community__videos';

    public function up()
    {
        $this->addColumn($this->_table, 'photo_id', 'int(11) unsigned');
        $this->addForeignKey('fk_' . $this->_table . '_photo', $this->_table, 'photo_id', 'album__photos', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey('fk_' . $this->_table . '_photo', $this->_table);
        $this->dropColumn($this->_table, 'photo_id');
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