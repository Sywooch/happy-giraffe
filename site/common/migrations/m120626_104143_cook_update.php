<?php

class m120626_104143_cook_update extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipe_ingredients` CHANGE `value` `value` DECIMAL( 6, 2 ) UNSIGNED NOT NULL ;
ALTER TABLE `cook__recipe_ingredients` CHANGE `display_value` `display_value` VARCHAR( 6 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;");
	}

	public function down()
	{
		echo "m120626_104143_cook_update does not support migration down.\n";
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