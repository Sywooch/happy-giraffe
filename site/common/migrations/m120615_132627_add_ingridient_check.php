<?php

class m120615_132627_add_ingridient_check extends CDbMigration
{
    private $_table = 'cook__ingredients';

    public function up()
    {
        $this->addColumn($this->_table, 'checked', 'tinyint(1) default 0 NOT NULL');
    }

    public function down()
    {
        $this->dropColumn($this->_table, 'checked');
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