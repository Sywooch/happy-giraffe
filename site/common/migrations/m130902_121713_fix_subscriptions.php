<?php

class m130902_121713_fix_subscriptions extends CDbMigration
{
    private $_table = 'user__community_subscriptions';

    public function up()
    {
        $this->execute('delete from ' . $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'user__club_subscriptions';
        $this->createTable($this->_table, array(
            'user_id' => 'int(11) unsigned NOT NULL',
            'club_id' => 'int(11) unsigned NOT NULL',
            'PRIMARY KEY (`user_id`, `club_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_club', $this->_table, 'club_id', 'community__clubs', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m130902_121713_fix_subscriptions does not support migration down.\n";
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