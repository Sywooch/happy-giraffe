<?php

class m111227_102006_rp_3 extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `recipeBook_disease_category` ADD `slug` VARCHAR( 255 ) NOT NULL 
		");
	}

	public function down()
	{
		echo "m111227_102006_rp_3 does not support migration down.\n";
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