<?php

class m160719_085350_create_qa_rating_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('qa__rating', array(
			'user_id' => 'int NOT NULL',
			'category_id' => 'int NOT NULL',
			'answers_count' => 'int NOT NULL DEFAULT 0',
			'votes_count' => 'int NOT NULL DEFAULT 0',
			'total_count' => 'int NOT NULL DEFAULT 0',
		));

		$this->createIndex('user_category_idx', 'qa__rating', 'user_id,category_id', true);
		$this->createIndex('category_idx', 'qa__rating', 'category_id');
	}

	public function down()
	{
		$this->dropTable('qa__rating');
	}
}