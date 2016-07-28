<?php

class m160712_094527_add_tag_id_to_qa_question extends CDbMigration
{
	public function up()
	{
		$this->addColumn('qa__questions', 'tag_id', 'int');
	}

	public function down()
	{
		$this->dropColumn('qa__questions', 'tag_id');
	}
}