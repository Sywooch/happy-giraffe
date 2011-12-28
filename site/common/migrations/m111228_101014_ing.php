<?php

class m111228_101014_ing extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `recipeBook_ingredient` CHANGE `unit` `unit` TINYINT( 3 ) UNSIGNED NOT NULL ");
	}

	public function down()
	{
		echo "m111228_101014_ing does not support migration down.\n";
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