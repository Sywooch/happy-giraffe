<?php

class m160802_000449_create_user_ref_links_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user__ref_links', array(
			'id' => 'pk',
			'user_id' => 'int NOT NULL',
			'ref' => 'string NOT NULL',
			'event' => 'int NOT NULL'
		));

		$this->createIndex('user_idx', 'user__ref_links', 'user_id');
		$this->createIndex('ref_idx', 'user__ref_links', 'ref');
		$this->createIndex('event_idx', 'user__ref_links', 'event');
		$this->createIndex('full_idx', 'user__ref_links', 'user_id, ref, event');
	}

	public function down()
	{
		$this->dropTable('user__ref_links');
	}
}