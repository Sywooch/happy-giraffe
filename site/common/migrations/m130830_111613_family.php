<?php

class m130830_111613_family extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user__users_partners` ADD `main_photo_id` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `notice`;");
        $this->execute("ALTER TABLE `user__users_partners` ADD INDEX `Photo` (`main_photo_id`);");
        $this->execute("ALTER TABLE `user__users_partners` ADD CONSTRAINT `Photo` FOREIGN KEY (`main_photo_id`) REFERENCES `album__photos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `user__users_babies` ADD `main_photo_id` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `type`;");
        $this->execute("ALTER TABLE `user__users_babies` ADD INDEX `Photo` (`main_photo_id`);");
        $this->execute("ALTER TABLE `user__users_babies` ADD FOREIGN KEY (`main_photo_id`) REFERENCES `album__photos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m130830_111613_family does not support migration down.\n";
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