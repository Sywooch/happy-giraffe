<?php

class m120418_070714_mood_relation_fix extends CDbMigration
{
    private $_table = 'users';

    public function up()
    {
        $fk = 'SELECT `CONSTRAINT_NAME`
              FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "users" AND `REFERENCED_TABLE_NAME` = "user__moods" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $fk = Yii::app()->db->createCommand($fk)->queryScalar();
        echo $fk;
        $this->dropForeignKey($fk, 'users');

        $this->addForeignKey('fk_' . $this->_table . '_mood', $this->_table, 'mood_id', 'user__moods', 'id', 'SET NULL', "SET NULL");
    }

    public function down()
    {
//        echo "m120418_070714_mood_relation_fix does not support migration down.\n";
//        return false;
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