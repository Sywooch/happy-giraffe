<?php

class m161031_124901_add_key_to_ansewrs extends CDbMigration
{
	public function up()
	{
	    $this->createIndex('root_id_authorId', 'qa__answers', 'authorId,root_id');
	}

	public function down()
	{
		echo "m161031_124901_add_key_to_ansewrs does not support migration down.\n";
		return false;
	}

}