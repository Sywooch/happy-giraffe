<?php

class m120604_072305_update_units extends CDbMigration
{
    public function up()
    {
        $this->update('cook__units', array(
            'title' => 'грамм',
            'title2' => 'грамма',
            'title3' => 'грамм'
        ), 'id=:id', array(':id' => 1));
    }

    public function down()
    {
        echo "m120604_072305_update_units does not support migration down.\n";
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