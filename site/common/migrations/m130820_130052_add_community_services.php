<?php

class m130820_130052_add_community_services extends CDbMigration
{
    private $_table = 'services';

    public function up()
    {
        $this->addColumn($this->_table, 'community_id', 'int(11) UNSIGNED');
    }

    public function down()
    {
        $this->dropColumn($this->_table, 'community_id');
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