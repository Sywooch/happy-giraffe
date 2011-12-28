<?php

class m111228_122949_recipe_source extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `recipeBook_recipe` ADD `source_type` ENUM( 'me', 'internet', 'book' ) NOT NULL ,
ADD `internet_link` VARCHAR( 255 ) NOT NULL ,
ADD `internet_favicon` VARCHAR( 255 ) NOT NULL ,
ADD `internet_title` VARCHAR( 255 ) NOT NULL ,
ADD `book_author` VARCHAR( 255 ) NOT NULL ,
ADD `book_name` VARCHAR( 255 ) NOT NULL 
		");
	}

	public function down()
	{
		echo "m111228_122949_recipe_source does not support migration down.\n";
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