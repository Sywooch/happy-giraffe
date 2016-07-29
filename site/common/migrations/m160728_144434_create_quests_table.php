<?php

class m160728_144434_create_quests_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('quests', array(
			'id' => 'pk',
			'user_id' => 'int NOT NULL',
			'name' => 'string NOT NULL',
			'description' => 'text',
			'end_date' => 'int',
			'type_id' => 'int NOT NULL',
			'model_name' => 'string NOT NULL',
			'model_id' => 'int NOT NULL',
			'settings' => 'text',
			'is_completed' => 'bool default false',
			'is_dropped' => 'bool default false',
		));

		$this->createIndex('user_idx', 'quests', 'user_id');
		$this->createIndex('type_idx', 'quests', 'type_id');
		$this->createIndex('user_type_idx', 'quests', 'user_id, type_id');
		$this->createIndex('single_quest_idx', 'quests', 'user_id, type_id, model_name, model_id');
		$this->createIndex('user_completed_idx', 'quests', 'user_id, is_completed');
		$this->createIndex('user_dropped_idx', 'quests', 'user_id, is_dropped');
	}

	public function down()
	{
		$this->dropTable('quests');
	}
}