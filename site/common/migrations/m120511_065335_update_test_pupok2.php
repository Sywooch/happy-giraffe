<?php

class m120511_065335_update_test_pupok2 extends CDbMigration
{
	public function up()
	{
        $this->insert('test__question_answers', array(
            'id' => 169,
            'test_question_id' => 53,
            'number' => 44,
            'points' => -1,
            'text' => 'Есть покраснения',
            'islast' => 0
        ));
	}

	public function down()
	{
		echo "m120511_065335_update_test_pupok2 does not support migration down.\n";
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