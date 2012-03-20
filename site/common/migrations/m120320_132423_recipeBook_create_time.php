<?php

class m120320_132423_recipeBook_create_time extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `recipeBook_recipe` ADD `updated` TIMESTAMP NOT NULL AFTER `name` ,
ADD `created` TIMESTAMP NOT NULL AFTER `updated` ;

ALTER TABLE `recipeBook_recipe` DROP `create_time` ;");
	}

	public function down()
	{
		echo "m120320_132423_recipeBook_create_time does not support migration down.\n";
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