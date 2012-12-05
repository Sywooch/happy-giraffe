<?php

class m121205_134355_community_short_title extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__communities` ADD  `short_title` VARCHAR( 255 ) NOT NULL AFTER  `title`;");
        $this->execute("UPDATE  `happy_giraffe`.`community__communities` SET  `short_title` =  'Подростковая психология' WHERE  `community__communities`.`id` =18;");
        $this->execute("UPDATE  `happy_giraffe`.`community__communities` SET  `short_title` =  'Мода и шопинг' WHERE  `community__communities`.`id` =30;");
	}

	public function down()
	{
		echo "m121205_134355_community_short_title does not support migration down.\n";
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