<?php

class m120925_061103_user_socials extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `user__social_services` ADD  `name` VARCHAR( 255 ) NOT NULL ,
ADD  `url` VARCHAR( 255 ) NOT NULL");
	}

	public function down()
	{
		echo "m120925_061103_user_socials does not support migration down.\n";
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