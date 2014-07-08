<?php

class m140320_102302_citiesFilled extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `geo__country` ADD `citiesFilled` TINYINT(1)  UNSIGNED  NOT NULL  AFTER `pos`;");
        $this->execute("UPDATE geo__country SET citiesFilled = 1 WHERE id IN (174, 20, 221, 109)");
	}

	public function down()
	{
		echo "m140320_102302_citiesFilled does not support migration down.\n";
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