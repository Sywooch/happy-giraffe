<?php

class m120416_122126_rename_test extends CDbMigration
{
	public function up()
	{
        $this->renameTable('test', 'test__tests');
        $this->renameTable('test_question', 'test__questions');
        $this->renameTable('test_question_answer', 'test__question_answers');
        $this->renameTable('test_result', 'test__results');
	}

	public function down()
	{
		echo "m120416_122126_rename_test does not support migration down.\n";
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