<?php

class m120511_061933_update_test_pupok extends CDbMigration
{
    public function up()
    {
        $this->insert('test__questions', array(
            'id' => 53,
            'test_id' => 4,
            'title' => 'Как выглядит кожа вокруг пупка?',
            'image' => 'bg_test_navel_02.jpg',
            'number' => 6
        ));
        $this->insert('test__question_answers', array(
            'id' => 168,
            'test_question_id' => 53,
            'number' => 43,
            'points' => 1,
            'text' => 'Как обычно',
            'islast' => 0
        ));
        $this->update('test__question_answers', array('points' => 0, 'next_question_id' => 53), 'id=136');
    }

    public function down()
    {
        echo "m120511_061933_update_test_pupok does not support migration down.\n";
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