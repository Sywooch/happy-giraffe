<?php

class m160719_085405_create_qa_rating_history_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('qa__rating_history', array(
			'user_id' => 'int NOT NULL',
			'category_id' => 'int NOT NULL',
			'created_at' => 'timestamp NOT NULL',
			'owner_model' => 'string NOT NULL',
			'owner_id' => 'int NOT NULL',
		));

		$this->createIndex('full_idx', 'qa__rating_history', 'user_id,category_id,created_at');
	}

	public function down()
	{
		$this->dropTable('qa__rating_history');
	}
}