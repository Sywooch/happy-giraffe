<?php

class m130219_091504_add_route_check extends CDbMigration
{
	public function up()
	{
        $this->execute("
        ALTER TABLE  `routes__routes` ADD  `checked` TINYINT( 2 ) NOT NULL DEFAULT  '0';
        ");
	}

	public function down()
	{
		echo "m130219_091504_add_route_check does not support migration down.\n";
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