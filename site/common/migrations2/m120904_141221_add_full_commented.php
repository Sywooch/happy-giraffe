<?php

class m120904_141221_add_full_commented extends CDbMigration
{
    private $_table = 'community__contents';

    public function up()
    {
        $this->addColumn($this->_table, 'full', 'tinyint(1)');
        $this->_table = 'cook__recipes';
        $this->addColumn($this->_table, 'full', 'tinyint(1)');
    }

    public function down()
    {
        echo "m120904_141221_add_full_commented does not support migration down.\n";
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