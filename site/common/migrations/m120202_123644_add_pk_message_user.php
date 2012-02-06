<?php

class m120202_123644_add_pk_message_user extends CDbMigration
{
    private $_table = 'message_user';

    public function up()
    {
        $this->addColumn($this->_table, 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
        $this->_table = 'message_cache';
        $this->addColumn($this->_table, 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
    }

    public function down()
    {
        $this->dropColumn($this->_table, 'id');
        $this->_table = 'message_cache';
        $this->dropColumn($this->_table, 'id');
    }
}