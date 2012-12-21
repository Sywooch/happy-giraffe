<?php

class m121217_115533_album__photos_title extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `album__photos` CHANGE  `title`  `title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	}

	public function down()
	{
		echo "m121217_115533_album__photos_title does not support migration down.\n";
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