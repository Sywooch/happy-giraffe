<?php

class m120618_125542_cookRecipe_fix extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` CHANGE `lowFat` `lowFat` TINYINT( 1 ) NULL ,
CHANGE `lowCal` `lowCal` TINYINT( 1 ) NULL ,
CHANGE `forDiabetics` `forDiabetics` TINYINT( 1 ) NULL
");
	}

	public function down()
	{
		echo "m120618_125542_cookRecipe_fix does not support migration down.\n";
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