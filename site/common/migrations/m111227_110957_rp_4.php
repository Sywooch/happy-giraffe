<?php

class m111227_110957_rp_4 extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `recipeBook_disease` ADD `diagnosis_name` VARCHAR( 255 ) NULL AFTER `symptoms_name` ;
ALTER TABLE `recipeBook_disease` ADD `diagnosis_text` TEXT NOT NULL AFTER `prophylaxis_text` ;
		");
	}

	public function down()
	{
		echo "m111227_110957_rp_4 does not support migration down.\n";
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