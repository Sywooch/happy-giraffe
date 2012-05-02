<?php

class m120502_091823_remove_test_columns extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('test__tests', 'css_class');
        $this->dropForeignKey('fk_test__question_answers_result', 'test__question_answers');
        $this->dropIndex('fk_test__question_answers_result', 'test__question_answers');
        $this->dropColumn('test__question_answers', 'result_id');
    }

    public function down()
    {
        echo "m120502_091823_remove_test_columns does not support migration down.\n";
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