<?php

class m131021_140659_clubFavourites extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('clubFavourites', '0', 'Избранное в клубах', NULL, NULL);");
	}

	public function down()
	{
		echo "m131021_140659_clubFavourites does not support migration down.\n";
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