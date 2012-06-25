<?php

class m120615_143150_recipeUpdate extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` ADD `lowFat` BOOLEAN NOT NULL ,
ADD `lowCal` BOOLEAN NOT NULL ,
ADD `forDiabetics` BOOLEAN NOT NULL");
	}

	public function down()
	{
		echo "m120615_143150_recipeUpdate does not support migration down.\n";
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