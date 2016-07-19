<?php

class m160719_141916_alter_answers_votes extends CDbMigration
{
	public function up()
	{
		$this->createIndex('answer_user_idx', 'qa__answers_votes', 'userId,answerId', true);
	}

	public function down()
	{
		$this->dropIndex('answer_user_idx', 'qa__answers_votes');
	}
}