<?php

class m130808_115756_groups_update_3 extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `sites__sites` ADD `group_id` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `type`;");
        $this->execute("ALTER TABLE `sites__sites` ADD INDEX `Group` (`group_id`);");
        $this->execute("ALTER TABLE `sites__sites` ADD CONSTRAINT `Group` FOREIGN KEY (`group_id`) REFERENCES `sites__groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `sites__sites` DROP `section`;");
	}

	public function down()
	{
		echo "m130808_115756_groups_update_3 does not support migration down.\n";
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