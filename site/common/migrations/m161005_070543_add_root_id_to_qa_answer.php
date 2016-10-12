<?php

class m161005_070543_add_root_id_to_qa_answer extends CDbMigration
{
	public function up()
	{
		$this->addColumn('qa__answers', 'root_id', 'int unsigned');
		$this->addForeignKey('parent_fk', 'qa__answers', 'root_id', 'qa__answers', 'id', 'cascade', 'cascade');
	}

	public function down()
	{
		$this->dropColumn('qa__answers', 'root_id');
		$this->dropForeignKey('parent_fk', 'qa__answers');
	}
}