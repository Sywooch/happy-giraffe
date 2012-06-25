<?php

class m120625_131142_recipe_display_value extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipe_ingredients` ADD `display_value` VARCHAR( 5 ) NOT NULL ");
	}

	public function down()
	{
		echo "m120625_131142_recipe_display_value does not support migration down.\n";
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