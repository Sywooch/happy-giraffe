<?php

class m160712_082304_create_qa_tags_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('qa__tags', array(
			'id' => 'pk',
			'category_id' => 'int NOT NULL',
			'name' => 'string NOT NULL',
		));

		$this->createIndex('category_idx', 'qa__tags', 'category_id');
	}

	public function down()
	{
		$this->dropTable('qa__tags');
	}
}