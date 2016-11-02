<?php

class m161101_142810_add_key_to_answers2 extends CDbMigration
{
	public function up()
	{
	    $this->createIndex('root_id_isRemoved', 'qa__answers', 'isRemoved,root_id');
	    $this->createIndex('questionId_isRemoved', 'qa__answers', 'isRemoved,questionId');
	}

	public function down()
	{
		echo "m161101_142810_add_key_to_answers2 does not support migration down.\n";
		return false;
	}
}