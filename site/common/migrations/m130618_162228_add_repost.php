<?php

class m130618_162228_add_repost extends CDbMigration
{
    private $_table = 'community__contents';

    public function up()
    {
        $this->addColumn($this->_table, 'source_id', 'int(11) UNSIGNED');
        $this->addForeignKey('fk_' . $this->_table . '_source', $this->_table, 'source_id', $this->_table, 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        echo "m130618_162228_add_repost does not support migration down.\n";
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