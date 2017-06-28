<?php

class m170504_063137_add_id_to_action_tokens extends CDbMigration
{
	public function up()
	{
		$this->addColumn('action_tokens', 'id', 'pk');
	}

	public function down()
	{
		$this->dropColumn('action_tokens', 'id');
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