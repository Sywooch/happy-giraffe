<?php

class m120207_091516_delete_messages extends CDbMigration
{
    private $_table = 'message_log';

    public function up()
    {
        $this->dropColumn($this->_table, 'deleted');
        $this->_table = 'message_deleted';
        $this->createTable($this->_table,
            array(
                'message_id' => 'int(10) UNSIGNED not null',
                'user_id' => 'int(10) UNSIGNED not null',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_message_fk', $this->_table, 'message_id', 'message_log', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'message_dialog';
        $this->dropColumn($this->_table,'cache');
    }

    public function down()
    {
        $this->addColumn($this->_table, 'deleted', 'tinyint(1)');
        $this->_table = 'message_deleted';
        $this->dropTable($this->_table);
        $this->_table = 'message_dialog';
        $this->addColumn($this->_table, 'cache', 'varchar(100)');
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