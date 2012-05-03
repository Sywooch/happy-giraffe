<?php

class m120502_052548_test_fx extends CDbMigration
{
	public function up()
	{
        $this->update('test__question_answers', array('text'=>'Сухой пупок, нет ни корочек, ни выделений'), 'id=156');
	}

	public function down()
	{

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