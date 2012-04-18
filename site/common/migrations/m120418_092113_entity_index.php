<?php

class m120418_092113_entity_index extends CDbMigration
{
	public function up()
	{
        $this->createIndex('entity_index', 'album__photo_attaches', 'entity, entity_id');
        $this->createIndex('entity_index', 'comments', 'entity, entity_id');
        $this->createIndex('entity_index', 'reports', 'entity, entity_id');
	}

	public function down()
	{
		echo "m120418_092113_entity_index does not support migration down.\n";
		return false;
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