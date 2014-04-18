<?php

class m140415_065130_country_pos extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE geo__country
SET pos = 100
WHERE `name` NOT IN ('Россия', 'Украина', 'Белоруссия', 'Казахстан');");
	}

	public function down()
	{
		echo "m140415_065130_country_pos does not support migration down.\n";
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