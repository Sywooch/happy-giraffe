<?php

class m130810_062837_score_user_awards extends CDbMigration
{
    private $_table = 'score__users_awards';

    public function up()
    {
        $this->dropTable($this->_table);
        $this->createTable($this->_table, array(
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'user_id' => 'int(11) unsigned NOT NULL',
            'award_id' => 'int(11) unsigned NOT NULL',
            'created' => 'date NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_' . $this->_table . '_user', $this->_table, 'user_id', 'users', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey('fk_' . $this->_table . '_award', $this->_table, 'award_id', 'score__awards', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {

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