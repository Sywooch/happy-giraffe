<?php

class m120301_134941_moods_fix extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user` DROP FOREIGN KEY `user_ibfk_1` ;

ALTER TABLE `user` ADD FOREIGN KEY ( `mood_id` ) REFERENCES `happy_giraffe`.`user_moods` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m120301_134941_moods_fix does not support migration down.\n";
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