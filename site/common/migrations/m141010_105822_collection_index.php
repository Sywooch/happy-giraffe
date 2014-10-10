<?php

class m141010_105822_collection_index extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `photo__collections` ADD UNIQUE INDEX (`entity`, `entity_id`, `key`);")
	}

	public function down()
	{
		echo "m141010_105822_collection_index does not support migration down.\n";
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