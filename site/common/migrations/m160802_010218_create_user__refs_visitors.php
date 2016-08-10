<?php

class m160802_010218_create_user__refs_visitors extends CDbMigration
{
	public function up()
	{
		$this->createTable('user__refs_visitors', array(
			'ref_id' => 'int NOT NULL',
			'ip' => 'string NOT NULL',
			'from' => 'string',
		));

		$this->createIndex('ref_idx', 'user__refs_visitors', 'ref_id');
	}

	public function down()
	{
		$this->dropTable('user__refs_visitors');
	}
}