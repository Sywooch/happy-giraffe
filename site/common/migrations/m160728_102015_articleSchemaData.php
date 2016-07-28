<?php

class m160728_102015_articleSchemaData extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `post__contents` ADD `articleSchemaData` TEXT  NULL;");
	}

	public function down()
	{
		echo "m160728_102015_addField does not support migration down.\n";
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