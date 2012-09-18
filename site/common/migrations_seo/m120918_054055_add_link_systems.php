<?php

class m120918_054055_add_link_systems extends CDbMigration
{
	public function up()
	{

        $this->execute("INSERT INTO `externallinks__systems` (`id`, `name`, `fee`) VALUES
(1, 'Ротапост', 15.8),
(2, 'GoGetLinks', 10.8),
(3, 'Миралинкс', 12.8);");

	}

	public function down()
	{
		echo "m120918_054055_add_link_systems does not support migration down.\n";
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