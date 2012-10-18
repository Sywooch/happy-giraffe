<?php

class m121018_122028_indexes extends CDbMigration
{
	public function up()
	{
        $this->execute("`ALTER TABLE comments DROP INDEX entity_id`");
        $this->execute("ALTER TABLE  `comments` ADD INDEX (  `updated` )");
	}

	public function down()
	{
		echo "m121018_122028_indexes does not support migration down.\n";
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