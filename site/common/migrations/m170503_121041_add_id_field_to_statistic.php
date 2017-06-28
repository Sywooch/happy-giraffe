<?php

class m170503_121041_add_id_field_to_statistic extends CDbMigration
{
	public function up()
	{
		$this->addColumn('specialist__chats_statistics', 'id', 'pk');
		$this->addColumn('chat__statistics_history', 'id', 'pk');
		$this->addColumn('users__balance_records', 'id', 'pk');
		$this->addColumn('users_balance', 'id', 'pk');
	}

	public function down()
	{
		$this->dropColumn('specialist__chats_statistics', 'id');
		$this->dropColumn('chat__statistics_history', 'id');
		$this->dropColumn('users__balance_records', 'id');
		$this->dropColumn('users_balance', 'id');
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