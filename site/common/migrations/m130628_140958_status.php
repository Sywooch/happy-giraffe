<?php

class m130628_140958_status extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__statuses` ADD `mood_id` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `text`;");
        $this->execute("ALTER TABLE `community__statuses` ADD CONSTRAINT `Mood` FOREIGN KEY (`mood_id`) REFERENCES `user__moods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m130628_140958_status does not support migration down.\n";
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