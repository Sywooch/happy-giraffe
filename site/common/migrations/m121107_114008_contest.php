<?php

class m121107_114008_contest extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `contest__contests` DROP `stop_reason`");
        $this->execute("ALTER TABLE `contest__contests` DROP `time`");
        $this->execute("ALTER TABLE `contest__contests` DROP `image`");
        $this->execute("ALTER TABLE  `contest__contests` DROP FOREIGN KEY  `fk_contest__contests_user` ;");
        $this->execute("ALTER TABLE `contest__contests` DROP `user_id`");
        $this->execute("ALTER TABLE  `contest__contests` CHANGE  `title`  `title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        $this->execute("ALTER TABLE  `contest__contests` CHANGE  `text`  `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        $this->execute("ALTER TABLE  `contest__contests` CHANGE  `from_time`  `from_time` DATE NOT NULL");
        $this->execute("ALTER TABLE  `contest__contests` CHANGE  `till_time`  `till_time` DATE NOT NULL");
        $this->execute("ALTER TABLE  `contest__contests` CHANGE  `status`  `status` TINYINT( 1 ) UNSIGNED NOT NULL");

	}

	public function down()
	{
		echo "m121107_114008_contest does not support migration down.\n";
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