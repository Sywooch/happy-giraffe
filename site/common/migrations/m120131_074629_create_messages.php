<?php

class m120131_074629_create_messages extends CDbMigration
{
    private $_table = 'message_cache';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'user_id' => 'int UNSIGNED NOT NULL',
                'cache' => 'VARCHAR(100) NOT NULL',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'message_log';
        $this->createTable($this->_table,
            array(
                'dialog_id' => 'INT(10) UNSIGNED NOT NULL',
                'user_id' => ' INT(10) UNSIGNED DEFAULT NULL',
                'text' => 'text',
                'created' => 'datetime DEFAULT NULL',
                'read_status'=>'tinyint(1)',
                'deleted'=>'tinyint(1)',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'message_dialog';
        $this->createTable($this->_table,
            array(
                'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT',
                'cache' => ' VARCHAR(100) NOT NULL',
                'title' => 'VARCHAR(100) DEFAULT NULL',
                'PRIMARY KEY (`id`)',
                'KEY `message_cache` (`cache`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'message_user';
        $this->createTable($this->_table,
            array(
                'dialog_id' => 'INT(10) UNSIGNED NOT NULL',
                'user_id' => ' INT(10) UNSIGNED DEFAULT NULL',
                'UNIQUE KEY `message_users_uq` (`dialog_id`,`user_id`)',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_dialog_fk', $this->_table, 'dialog_id', 'message_dialog', 'id','CASCADE',"CASCADE");

        $this->_table = 'message_log';
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_dialog_fk', $this->_table, 'dialog_id', 'message_dialog', 'id','CASCADE',"CASCADE");

        $this->_table = 'message_cache';
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        $this->_table = 'message_user';
        $this->dropForeignKey($this->_table.'_user_fk', $this->_table);
        $this->dropForeignKey($this->_table.'_dialog_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'message_log';
        $this->dropForeignKey($this->_table.'_user_fk', $this->_table);
        $this->dropForeignKey($this->_table.'_dialog_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'message_cache';
        $this->dropForeignKey($this->_table.'_user_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'message_dialog';
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