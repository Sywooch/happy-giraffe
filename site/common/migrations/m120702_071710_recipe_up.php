<?php

class m120702_071710_recipe_up extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` CHANGE `preparation_duration` `preparation_duration` SMALLINT( 4 ) UNSIGNED NULL DEFAULT NULL ,
CHANGE `cooking_duration` `cooking_duration` SMALLINT( 4 ) UNSIGNED NULL DEFAULT NULL ");
	}

	public function down()
	{
		echo "m120702_071710_recipe_up does not support migration down.\n";
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