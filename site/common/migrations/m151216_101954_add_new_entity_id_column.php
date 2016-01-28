<?php

class m151216_101954_add_new_entity_id_column extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE `comments` ADD COLUMN `new_entity_id`  int(10) UNSIGNED NOT NULL AFTER `root_id`, ADD INDEX `new_entity_id` (`new_entity_id`) USING BTREE ;');
	}

	public function down()
	{
		$this->execute('ALTER TABLE `comments` DROP COLUMN `new_entity_id`;');
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