<?php

class m120207_135734_delete_dialogs extends CDbMigration
{
    private $_table = 'message_dialog_deleted';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id'=>'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'dialog_id' => 'int(10) UNSIGNED not null',
                'message_id' => 'int(10) UNSIGNED not null',
                'user_id' => 'int(10) UNSIGNED not null',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_message_fk', $this->_table, 'message_id', 'message_log', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_dialog_fk', $this->_table, 'dialog_id', 'message_dialog', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }

}