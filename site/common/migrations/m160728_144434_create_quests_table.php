<?php

class m160728_144434_create_quests_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('quests', array(
			'id' => 'pk',
			'user_id' => 'int NOT NULL',
			'end_date' => 'int',
			'type_id' => 'int NOT NULL',
			'settings' => 'text',
		));

		$this->createIndex('user_idx', 'quests', 'user_id');
		$this->createIndex('type_idx', 'quests', 'type_id');
		$this->createIndex('user_type_idx', 'quests', 'user_id, type_id');
	}

	public function down()
	{
		$this->dropTable('quests');
	}
}