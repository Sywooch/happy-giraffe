<?php

class m160617_064148_forum_column extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `community__contents` ADD `forum_id` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `test2`;");
		$this->execute("ALTER TABLE `community__contents` ADD INDEX (`forum_id`);");
		$this->execute("UPDATE community__contents c
JOIN community__rubrics r ON r.id = c.rubric_id
SET c.forum_id = r.community_id
WHERE r.community_id IS NOT NULL;");
		$this->execute("ALTER TABLE `community__contents` ADD FOREIGN KEY (`forum_id`) REFERENCES `community__forums` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m160617_064148_forum_column does not support migration down.\n";
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